<x-layouts.app>
    <x-slot:title>Prévisualisation</x-slot:title>

    <div class="max-w-4xl mx-auto px-4 md:px-6 py-6">
        <div class="bg-white rounded-xl shadow p-6 mb-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-bold">Prévisualisation : {{ $originalFilename }}</h2>
                    <p class="text-sm text-gray-500">Valides : <strong>{{ $validCount }}</strong> — Invalides : <strong
                            class="text-red-600">{{ $invalidCount }}</strong></p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('bulk-payment.index') }}" class="text-sm text-gray-600">Retour</a>
                    <form action="{{ route('bulk-payment.import') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cache_key" value="{{ $cacheKey }}" />
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded shadow">Importer
                            les {{ $validCount }} valides</button>
                    </form>
                </div>
            </div>

            @if ($invalidCount > 0)
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">Attention !</strong>
                    <span class="block sm:inline"> Des erreurs ont été détectées.</span>
                    <ul class="mt-2 space-y-2 text-sm">
                        @foreach ($invalidRows as $row)
                            <li class="border p-2 rounded bg-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-xs text-gray-500">Ligne {{ $row['line'] }} — ID: <span
                                                class="font-mono">{{ $row['home_transaction_id'] }}</span></div>
                                        <div class="mt-1 text-sm">
                                            @foreach ($row['errors'] as $err)
                                                <div class="text-red-600">• {{ $err }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-xs text-gray-500 mt-3">Corrigez le fichier CSV et renvoyez-le, ou téléchargez le
                        rapport des invalides si nécessaire.</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold mb-2">Extrait des lignes valides</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-xs text-gray-500 border-b">
                            <th class="py-2 text-left">ID</th>
                            <th class="py-2 text-left">Bénéficiaire</th>
                            <th class="py-2 text-left">Devise</th>
                            <th class="py-2 text-left">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($validRowsSample as $r)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 font-mono">{{ $r['home_transaction_id'] }}</td>
                                <td class="py-2">{{ $r['beneficiary_name'] }}</td>
                                <td class="py-2">{{ $r['currency'] }}</td>
                                <td class="py-2">{{ number_format($r['amount'], 0, ',', ' ') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
