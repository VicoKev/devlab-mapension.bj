<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Models\PaymentBatch;
use App\Services\MojaloopService;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessBulkPaymentsJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public PaymentBatch $batch;
    public int $timeout = 3600;

    public function __construct(PaymentBatch $batch)
    {
        $this->batch = $batch;
    }

    public function handle(MojaloopService $mojaloopService)
    {
        $this->batch->update(['status' => 'processing', 'started_at' => now()]);
        $items = $this->batch->payments()->where('status','pending')->orderBy('id')->chunk(100, function($payments) use ($mojaloopService) {
            foreach ($payments as $payment) {
                try {
                    $payment->update(['status' => 'processing']);
                    $res = $mojaloopService->sendTransfer(
                        beneficiaryName: $payment->beneficiary_name,
                        beneficiaryIdType: $payment->beneficiary_id_type,
                        beneficiaryIdValue: $payment->beneficiary_id_value,
                        amount: $payment->amount,
                        currency: $payment->currency,
                        note: "Pension - {$this->batch->batch_reference}",
                        homeTransactionId: $payment->home_transaction_id
                    );

                    if (!empty($res['success'])) {
                        $payment->update([
                            'status' => 'success',
                            'mojaloop_transaction_id' => $res['mojaloop_transaction_id'] ?? null,
                            'mojaloop_response' => $res['response'] ?? null,
                            'processed_at' => now()
                        ]);
                    } else {
                        $payment->update([
                            'status' => 'failed',
                            'error_message' => $res['message'] ?? 'Erreur Mojaloop',
                            'mojaloop_response' => $res['response'] ?? null,
                            'processed_at' => now()
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error("Payment {$payment->id} error: ".$e->getMessage());
                    $payment->update([
                        'status' => 'failed',
                        'error_message' => 'Erreur système: '.$e->getMessage(),
                        'processed_at' => now()
                    ]);
                }
            }
        });

        $this->batch->updateStatistics();
    }
}
