<x-layouts.app>
    <x-slot:title>
        Uploader CSV
    </x-slot:title>

    <div class="max-w-3xl mx-auto px-4 md:px-6 py-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold mb-2">Téléverser un fichier CSV</h2>
            <p class="text-sm text-gray-500 mb-4">Colonnes attendues : <code>type_id, valeur_id, devise, montant,
                    nom_complet</code></p>

            <form action="{{ route('bulk-payment.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fichier CSV</label>
                        <input type="file" name="csv_file" accept=".csv" required
                            class="mt-1 block w-full text-sm text-gray-700" />
                        @error('csv_file')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="#" class="text-sm text-gray-500">Télécharger un modèle CSV</a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded shadow">Téléverser
                            & Prévisualiser</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
