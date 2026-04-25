<!-- Nouvelle transaction Modal -->
<dialog id="transactionModal" class="backdrop:bg-gray-800/50 p-0 rounded-2xl shadow-xl w-full max-w-lg mx-auto bg-white border-0 open:backdrop-blur-sm transition-all">
    <div class="p-6">
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-lg font-semibold text-gray-900">Nouvelle transaction</h3>
            <button type="button" onclick="document.getElementById('transactionModal').close()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="{{ route('admin.paiements.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie véhicule</label>
                    <select name="categorie_vehicule_id" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
                        <option value="">Sélectionner...</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}">{{ $categorie->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mode de paiement</label>
                    <select name="type_paiement_id" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
                        <option value="">Sélectionner...</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->libelle }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Immatriculation</label>
                <input type="text" name="immatriculation" placeholder="Facultatif (ex: 1234 AB 01)" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
            </div>

            <div class="mt-4 flex items-center bg-gray-50 p-3 rounded-lg border border-gray-100">
                <input type="checkbox" name="auto_print" id="auto_print" value="1" class="h-4 w-4 text-[#1D9E75] focus:ring-[#1D9E75] border-gray-300 rounded" checked>
                <label for="auto_print" class="ml-2 block text-sm font-medium text-gray-700 cursor-pointer">Impression automatique du ticket de reçu</label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-5">
                <button type="button" onclick="document.getElementById('transactionModal').close()" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-[#1D9E75] text-white rounded-lg text-sm hover:bg-[#0F6E56]">Enregistrer le paiement</button>
            </div>
        </form>
    </div>
</dialog>
