<x-layouts.app>
    <x-slot:title>Détails du Batch</x-slot:title>

    <div class="max-w-6xl mx-auto px-4 md:px-6 py-6">

        {{-- Retour --}}
        <div class="mb-6">
            <a href="{{ route('bulk-payment.index') }}"
                class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-800 font-medium text-sm"
                aria-label="Retour à l'accueil">
                <svg class="w-4 h-4 flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>

                <span>Retour à l'accueil</span>
            </a>
        </div>

        {{-- Header batch --}}
        <div class="bg-white rounded-xl shadow-md p-6 md:p-8 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $batch->batch_reference }}</h2>
                    <p class="text-gray-600 text-sm mt-1">{{ $batch->filename }} •
                        {{ $batch->created_at->format('d/m/Y à H:i') }}</p>
                </div>

                <div class="flex items-center gap-3">
                    @php
                        // Nombre de paiements valides (status pending)
                        $validPaymentsCount = $batch->payments->where('status', 'pending')->count();
                        $invalidPaymentsCount = is_array($batch->invalid_records) ? count($batch->invalid_records) : 0;
                    @endphp

                    @if (in_array($batch->status, ['pending', 'partially_completed']) && $validPaymentsCount > 0)
                        <form action="{{ route('bulk-payment.process', $batch->id) }}" method="POST"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir lancer les paiements ?')">
                            @csrf
                            <button type="submit"
                                class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold py-2 px-5 rounded-lg hover:from-emerald-700 hover:to-teal-700 transition shadow-md">
                                Lancer les {{ $validPaymentsCount }} paiements valides
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('bulk-payment.download', $batch->id) }}"
                        class="inline-block bg-gray-800 text-white font-semibold py-2 px-5 rounded-lg hover:bg-gray-900 transition shadow-md">
                        Télécharger le Rapport
                    </a>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-600 mb-1">Total</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $batch->total_records }}</p>
                    <p class="text-xs text-gray-500">paiements</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-xs text-green-600 mb-1">Succès</p>
                    <p class="text-2xl font-bold text-green-800">{{ $batch->successful_payments }}</p>
                    <p class="text-xs text-green-600">
                        {{ $batch->total_records > 0 ? round(($batch->successful_payments / $batch->total_records) * 100) : 0 }}%
                    </p>
                </div>
                <div class="bg-red-50 rounded-lg p-4">
                    <p class="text-xs text-red-600 mb-1">Échecs</p>
                    <p class="text-2xl font-bold text-red-800">{{ $batch->failed_payments }}</p>
                    <p class="text-xs text-red-600">
                        {{ $batch->total_records > 0 ? round(($batch->failed_payments / $batch->total_records) * 100) : 0 }}%
                    </p>
                </div>
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-xs text-blue-600 mb-1">Montant Total</p>
                    <p class="text-lg font-bold text-blue-800">{{ number_format($batch->total_amount, 0, ',', ' ') }}
                    </p>
                    <p class="text-xs text-blue-600">FCFA</p>
                </div>
            </div>
        </div>

        {{-- Table des paiements valides --}}
        <div class="bg-white rounded-xl shadow-md p-6 md:p-8 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Liste des Paiements</h3>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px] text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-200 text-left">
                            <th class="pb-3 text-sm font-semibold text-gray-700">Transaction ID</th>
                            <th class="pb-3 text-sm font-semibold text-gray-700">Bénéficiaire</th>
                            <th class="pb-3 text-sm font-semibold text-gray-700">Montant</th>
                            <th class="pb-3 text-sm font-semibold text-gray-700">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($batch->payments as $payment)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 text-xs text-gray-500 whitespace-nowrap">
                                    {{ $payment->home_transaction_id ?? '-' }}</td>
                                <td class="py-3">
                                    <p class="text-sm md:text-base font-medium text-gray-900">
                                        {{ $payment->beneficiary_name }}</p>
                                    <p class="text-xs md:text-sm text-gray-500">{{ $payment->beneficiary_id_type }} •
                                        {{ $payment->beneficiary_id_value }}</p>
                                </td>
                                <td class="py-3 text-sm md:text-base font-semibold text-gray-900">
                                    {{ number_format($payment->amount, 0, ',', ' ') }} FCFA</td>
                                <td class="py-3">
                                    @if ($payment->status === 'success')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Succès</span>
                                    @elseif($payment->status === 'failed')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Échec</span>
                                    @elseif($payment->status === 'processing')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En
                                            cours</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">En
                                            attente</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-gray-500">Aucun paiement importé pour ce
                                    batch.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Section lignes invalides (si présentes) --}}
        @if (!empty($batch->invalid_records) && is_array($batch->invalid_records))
            <div class="mb-6 bg-yellow-100 border border-yellow-400 p-4 rounded-lg">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h4 class="font-semibold text-yellow-800">Lignes non importées
                            ({{ count($batch->invalid_records) }})</h4>
                        <p class="text-sm text-yellow-700">Ces lignes n'ont pas été insérées dans la base. Elles sont
                            listées ci-dessous et apparaissent également dans le rapport téléchargeable.</p>
                    </div>
                    <div class="text-sm text-gray-600">
                        <a href="{{ route('bulk-payment.download', $batch->id) }}"
                            class="inline-block bg-gray-800 text-white font-semibold py-2 px-5 rounded-lg hover:bg-gray-900 transition shadow-md">Télécharger
                            le rapport</a>
                    </div>
                </div>

                <ul class="space-y-3">
                    @foreach ($batch->invalid_records as $inv)
                        <li class="p-3 bg-white rounded-lg shadow mb-2">
                            <div>
                                <div class="text-sm font-mono">{{ $inv['home_transaction_id'] ?? '-' }} — Ligne:
                                    {{ $inv['line'] ?? '-' }}</div>
                                <div class="mt-1 text-sm text-yellow-800">
                                    @if (!empty($inv['error']))
                                        {{ $inv['error'] }}
                                    @elseif(!empty($inv['errors']) && is_array($inv['errors']))
                                        <ul class="list-disc list-inside">
                                            @foreach ($inv['errors'] as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        Données invalides
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif


    </div>
</x-layouts.app>
