<x-layouts.app>
    <x-slot:title>
        Gestion des lots
    </x-slot:title>

    <div class="max-w-6xl mx-auto">
        <!-- Upload Section -->
        <div class="bg-white rounded-xl shadow-md p-6 md:p-8 mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-emerald-100 p-3 rounded-lg mr-4">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Nouveau Paiement de Masse</h2>
                    <p class="text-gray-600 text-sm mt-1">Téléversez votre fichier CSV pour démarrer</p>
                </div>
            </div>

             <form action="{{ route('bulk-payment.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-emerald-500 transition">
                <input type="file" name="csv_file" id="csv_file" class="hidden" accept=".csv" required onchange="updateFileName(this)">
                <label for="csv_file" class="cursor-pointer">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">
                        <span class="font-semibold text-emerald-600">Cliquez pour sélectionner</span> ou glissez-déposez
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Fichier CSV (Max. 10 MB)</p>
                    <p id="file-name" class="text-sm text-emerald-600 font-medium mt-2 hidden"></p>
                </label>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                <p class="text-sm text-blue-800 font-medium mb-2">Format du fichier CSV requis:</p>
                <code class="text-xs text-blue-900 bg-white px-2 py-1 rounded block">type_id, valeur_id, devise, montant, nom_complet</code>
                <p class="text-xs text-blue-700 mt-2">Exemple: PERSONAL_ID, 8884191054, XOF, 20000, Abdou Kpangon</p>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-emerald-700 hover:to-teal-700 transition shadow-md hover:shadow-lg">
                Téléverser et Continuer
            </button>
        </form>
               
        </div>


        <div class="bg-white rounded-xl shadow p-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-500 border-b">
                        <th class="py-2">Référence</th>
                        <th class="py-2">Fichier</th>
                        <th class="py-2">Total</th>
                        <th class="py-2">Succès</th>
                        <th class="py-2">Échecs</th>
                        <th class="py-2">Statut</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($batches as $b)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 font-medium">{{ $b->batch_reference }}</td>
                            <td class="py-3 text-gray-600">{{ $b->filename }}</td>
                            <td class="py-3">{{ $b->total_records }}</td>
                            <td class="py-3 text-green-600">{{ $b->successful_payments }}</td>
                            <td class="py-3 text-red-600">{{ $b->failed_payments }}</td>
                            <td class="py-3"><span
                                    class="px-2 py-1 rounded-full text-xs {{ $b->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($b->status) }}</span>
                            </td>
                            <td class="py-3">
                                <a href="{{ route('bulk-payment.show', $b->id) }}"
                                    class="text-sm text-indigo-600">Voir</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="mt-4">{{ $batches->links() }}</div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0]?.name;
            const fileNameEl = document.getElementById('file-name');
            if (fileName) {
                fileNameEl.textContent = 'Fichier sélectionné: ' + fileName;
                fileNameEl.classList.remove('hidden');
            }
        }
    </script>


</x-layouts.app>
