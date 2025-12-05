<?php

namespace App\Http\Controllers;

use League\Csv\Reader;
use League\Csv\Writer;
use App\Models\Payment;
use Illuminate\Support\Str;
use App\Models\PaymentBatch;
use Illuminate\Http\Request;
use App\Services\MojaloopService;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessBulkPaymentsJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class BulkPaymentController extends Controller
{
    public function __construct(
        protected MojaloopService $mojalooService
    ) {}

    public function index()
    {
        $batches = PaymentBatch::orderBy('created_at', 'desc')->paginate(10);
        $mojalooStatus = $this->mojalooService->healthCheck();
        return view('bulk-payment.index', compact('batches', 'mojalooStatus'));
    }

    /**
     * Étape 1 : upload & preview
     * Parse le CSV, valide CHAQUE ligne, génère lists valid/invalid,
     * met en cache temporaire (clé) et affiche la preview.
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:51200'
        ], [
            'csv_file.required' => 'Veuillez sélectionner un fichier CSV',
            'csv_file.mimes' => 'Le fichier doit être au format CSV',
            'csv_file.max' => 'Le fichier ne doit pas dépasser 50 MB'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return back()->with('toast_error', $message)->withInput();
        }

        try {
            $file = $request->file('csv_file');
            $csv = Reader::createFromPath($file->getRealPath());
            $csv->setHeaderOffset(0);

            $headers = $csv->getHeader();
            $requiredHeaders = ['type_id', 'valeur_id', 'devise', 'montant', 'nom_complet'];
            $missingHeaders = array_diff($requiredHeaders, $headers);
            if (!empty($missingHeaders)) {
                return back()->with('toast_error', 'En-têtes manquants : ' . implode(', ', $missingHeaders));
            }

            $rows = iterator_to_array($csv->getRecords());
            if (empty($rows)) {
                return back()->with('toast_error', 'Le fichier CSV est vide.');
            }
            if (count($rows) > 10000) {
                return back()->with('toast_error', 'Le fichier contient trop de lignes (' . count($rows) . '). Maximum : 10,000 lignes.');
            }

            // Validation ligne par ligne (collecte erreurs)
            $validRows = [];
            $invalidRows = [];
            foreach ($rows as $index => $row) {
                $rowIndex = $index + 2; // ligne dans le CSV (header ligne 1)
                $errors = [];

                $beneficiaryName = trim($row['nom_complet'] ?? '');
                $typeId = trim($row['type_id'] ?? '');
                $valueId = trim($row['valeur_id'] ?? '');
                $currency = strtoupper(trim($row['devise'] ?? ''));
                $rawAmount = $row['montant'] ?? '';
                $amount = is_string($rawAmount) ? (float) str_replace([' ', ','], ['', '.'], $rawAmount) : (float)$rawAmount;

                if ($beneficiaryName === '') $errors[] = 'Nom du bénéficiaire manquant';
                if ($typeId === '') $errors[] = 'Type ID manquant';
                if ($valueId === '') $errors[] = 'Valeur ID manquante';
                if ($currency === '') $errors[] = 'Devise manquante';
                if ($amount <= 0) $errors[] = "Montant invalide : '{$rawAmount}'";

                // Générer home_transaction_id dès ici pour traçabilité
                $homeTxn = 'MAPENSION-' . strtoupper(Str::uuid()->toString());

                if (!empty($errors)) {
                    $invalidRows[] = [
                        'line' => $rowIndex,
                        'home_transaction_id' => $homeTxn,
                        'errors' => $errors,
                        'data' => $row,
                    ];
                } else {
                    $validRows[] = [
                        'line' => $rowIndex,
                        'home_transaction_id' => $homeTxn,
                        'beneficiary_name' => $beneficiaryName,
                        'beneficiary_id_type' => strtoupper($typeId),
                        'beneficiary_id_value' => $valueId,
                        'currency' => $currency,
                        'amount' => $amount,
                        'raw' => $row
                    ];
                }
            }

            // Stocker temporairement en cache — clé unique
            $cacheKey = 'bulk_import_preview_' . (string) Str::uuid();
            $payload = [
                'valid' => $validRows,
                'invalid' => $invalidRows,
                'original_filename' => $file->getClientOriginalName(),
                'uploaded_at' => now()->toDateTimeString(),
            ];
            // TTL 30 minutes (ajuster si besoin)
            Cache::put($cacheKey, $payload, now()->addMinutes(30));

            // Passer à la vue preview
            return view('bulk-payment.preview', [
                'cacheKey' => $cacheKey,
                'validCount' => count($validRows),
                'invalidCount' => count($invalidRows),
                'validRowsSample' => array_slice($validRows, 0, 50),
                'invalidRows' => $invalidRows,
                'originalFilename' => $file->getClientOriginalName(),
            ])->with('toast_info', 'Prévisualisation générée. Vérifiez les lignes invalides avant import.');
        } catch (\Exception $e) {
            return back()->with('toast_error', 'Erreur lors du traitement du fichier : ' . $e->getMessage());
        }
    }

    /**
     * Étape 2 : import des lignes valides (confirm)
     * Lecture du cache via $cacheKey et insertion en base des validRows seulement.
     */
    public function import(Request $request)
    {
        $request->validate(['cache_key' => 'required|string']);
        $cacheKey = $request->input('cache_key');
        $payload = Cache::get($cacheKey);

        if (!$payload) {
            return back()->with('toast_error', 'La prévisualisation a expiré. Téléversez de nouveau le fichier.');
        }

        $validRows = $payload['valid'] ?? [];
        $invalidRows = $payload['invalid'] ?? [];

        if (empty($validRows) && empty($invalidRows)) {
            return back()->with('toast_error', 'Aucune ligne trouvée dans la prévisualisation.');
        }

        DB::beginTransaction();
        try {
            $batchReference = 'BATCH-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));

            $batch = PaymentBatch::create([
                'batch_reference' => $batchReference,
                'filename' => $payload['original_filename'] ?? 'upload.csv',
                'total_records' => count($validRows) + count($invalidRows),
                'pending_payments' => count($validRows),
                'status' => 'pending',
                'invalid_records' => $invalidRows,
            ]);

            $totalAmount = 0;
            $paymentsData = [];
            foreach ($validRows as $r) {
                $paymentsData[] = [
                    'payment_batch_id' => $batch->id,
                    'beneficiary_name' => $r['beneficiary_name'],
                    'beneficiary_id_type' => $r['beneficiary_id_type'],
                    'beneficiary_id_value' => $r['beneficiary_id_value'],
                    'currency' => $r['currency'],
                    'amount' => $r['amount'],
                    'home_transaction_id' => $r['home_transaction_id'],
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $totalAmount += $r['amount'];
            }

            if (!empty($paymentsData)) {
                foreach (array_chunk($paymentsData, 500) as $chunk) {
                    Payment::insert($chunk);
                }
            }

            $batch->update(['total_amount' => $totalAmount]);

            DB::commit();

            // Supprimer la prévisualisation du cache
            Cache::forget($cacheKey);

            return redirect()->route('bulk-payment.show', $batch->id)
                ->with('toast_success', count($validRows) . ' paiements importés. ' . count($invalidRows) . ' lignes non importées.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('toast_error', 'Erreur lors de l’import en base : ' . $e->getMessage());
        }
    }

    /**
     * show(), process(), downloadReport(), refreshStatus()
     * show() reste similaire mais on charge invalid_records via $batch->invalid_records
     */
    public function show($id)
    {
        $batch = PaymentBatch::with(['payments' => function ($q) {
            $q->latest()->limit(100);
        }])->findOrFail($id);

        $stats = [
            'processing' => $batch->payments()->where('status', 'processing')->count(),
            'pending' => $batch->payments()->where('status', 'pending')->count(),
        ];

        // invalid_records est un array (cast)
        $invalidCount = is_array($batch->invalid_records) ? count($batch->invalid_records) : 0;

        return view('bulk-payment.show', compact('batch', 'stats', 'invalidCount'));
    }

    /**
     * process(): lance le job sur le batch — le job traitera les paiements en base
     */
    public function process($id)
    {
        $batch = PaymentBatch::with('payments')->findOrFail($id);

        if (!in_array($batch->status, ['pending', 'partially_completed'])) {
            return back()->with('toast_error', 'Ce batch ne peut pas être traité dans son état actuel.');
        }

        $validPaymentsCount = $batch->payments()->where('status', 'pending')->count();
        if ($validPaymentsCount === 0) {
            return back()->with('toast_error', 'Aucun paiement valide à traiter dans ce batch.');
        }

        // if (!$this->mojalooService->healthCheck()) {
        //     return back()->with('toast_error', 'Le service Mojaloop n\'est pas disponible. Veuillez réessayer plus tard.');
        // }

        // change status and dispatch job
        $batch->update(['status' => 'processing', 'started_at' => now()]);
        ProcessBulkPaymentsJob::dispatch($batch);

        return redirect()->route('bulk-payment.show', $batch->id)
            ->with('toast_success', "Le traitement des {$validPaymentsCount} paiements valides a été lancé.");
    }

    /**
     * downloadReport: inclut paiements valides ET section "non traités" à la fin
     */
    public function downloadReport($id)
    {
        $batch = PaymentBatch::with('payments')->findOrFail($id);
        $csv = Writer::createFromString();

        // headers
        $csv->insertOne([
            'Nom Complet',
            'Type ID',
            'Valeur ID',
            'Devise',
            'Montant',
            'Statut',
            'ID Transaction Interne',
            'ID Transaction Mojaloop',
            'Message Erreur',
            'Date Traitement'
        ]);

        foreach ($batch->payments as $payment) {
            $csv->insertOne([
                $payment->beneficiary_name,
                $payment->beneficiary_id_type,
                $payment->beneficiary_id_value,
                $payment->currency,
                $payment->amount,
                $payment->status,
                $payment->home_transaction_id,
                $payment->mojaloop_transaction_id ?? '',
                $payment->error_message ?? '',
                $payment->processed_at ? $payment->processed_at->format('d/m/Y H:i:s') : ''
            ]);
        }

        // invalid records (section)
        $invalids = $batch->invalid_records ?? [];
        if (!empty($invalids)) {
            $csv->insertOne([]);
            $csv->insertOne(['Paiements non traités :']);
            $csv->insertOne(['ID Transaction Interne', 'Nom Complet', 'Type ID', 'Valeur ID', 'Devise', 'Montant', 'Erreur']);
            foreach ($invalids as $inv) {
                $csv->insertOne([
                    $inv['home_transaction_id'] ?? '',
                    $inv['nom_complet'] ?? '',
                    $inv['type_id'] ?? '',
                    $inv['valeur_id'] ?? '',
                    $inv['devise'] ?? '',
                    $inv['montant'] ?? '',
                    $inv['error'] ?? ''
                ]);
            }
        }

        $filename = 'rapport-' . $batch->batch_reference . '.csv';
        return response($csv->toString(), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function refreshStatus($id)
    {
        $batch = PaymentBatch::findOrFail($id);
        $batch->updateStatistics();
        return response()->json([
            'status' => $batch->status,
            'successful_payments' => $batch->successful_payments,
            'failed_payments' => $batch->failed_payments,
            'pending_payments' => $batch->pending_payments,
        ]);
    }
}
