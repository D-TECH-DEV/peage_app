@extends('layouts.admin')

@section('title', 'Paramètres')

@section('content')
<div class="mb-6">
  <h1 class="text-xl font-semibold text-gray-900">Paramètres</h1>
  <p class="text-sm text-gray-500 mt-0.5">Configuration de l'application et données de référence.</p>
</div>

<!-- Tabs -->
<div class="border-b border-gray-200 mb-6 flex overflow-x-auto">
    <button id="link-general" onclick="switchTab('general')" class="tab-link whitespace-nowrap py-3 px-5 border-b-2 text-sm text-[#1D9E75] border-[#1D9E75] font-semibold transition">Général</button>
    <button id="link-categories" onclick="switchTab('categories')" class="tab-link whitespace-nowrap py-3 px-5 border-b-2 border-transparent text-sm text-gray-500 hover:text-gray-700 transition">Catégories de véhicules</button>
    <button id="link-paiements" onclick="switchTab('paiements')" class="tab-link whitespace-nowrap py-3 px-5 border-b-2 border-transparent text-sm text-gray-500 hover:text-gray-700 transition">Modes de paiement</button>
    <button id="link-tarifs" onclick="switchTab('tarifs')" class="tab-link whitespace-nowrap py-3 px-5 border-b-2 border-transparent text-sm text-gray-500 hover:text-gray-700 transition">Tarifs</button>
</div>

<!-- Tab Content: General -->
<div id="general" class="tab-content max-w-xl">
  <form action="" method="POST" class="bg-white border border-gray-100 rounded-2xl p-6 space-y-5">
    @csrf
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Nom du péage</label>
      <input type="text" name="name" value="Pont du Nord — Péage Principal" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]" />
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Devise</label>
      <select name="currency" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
        <option>F CFA (XOF)</option>
        <option>EUR</option>
        <option>USD</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Fuseau horaire</label>
      <select name="timezone" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
        <option>Africa/Abidjan (GMT+0)</option>
        <option>Europe/Paris (GMT+2)</option>
      </select>
    </div>
    <div class="pt-2 border-t border-gray-100 flex justify-end">
      <button type="button" onclick="alert('Paramètres enregistrés !')" class="bg-[#1D9E75] text-white text-sm px-5 py-2 rounded-lg hover:bg-[#0F6E56] transition">Enregistrer</button>
    </div>
  </form>
</div>

<!-- Tab Content: Categories -->
<div id="categories" class="tab-content hidden">
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
    <h3 class="text-base font-semibold text-gray-800">Catégories de véhicules enregistrées</h3>
    <button onclick="document.getElementById('modal-categorie').showModal()" class="text-sm px-4 py-2 bg-[#1D9E75] text-white rounded-lg hover:bg-[#0F6E56] transition">Nouvelle catégorie</button>
  </div>
  <div id="active-categories-container" class="bg-white border border-gray-100 rounded-2xl overflow-hidden overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 border-b border-gray-100">
        <tr>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">ID</th>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Libellé</th>
          <th class="text-right text-xs text-gray-400 font-normal px-5 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @forelse($categories as $cat)
        <tr class="hover:bg-gray-50/50">
          <td class="px-5 py-3 text-gray-500">#{{ $cat->id }}</td>
          <td class="px-5 py-3 font-medium text-gray-800">{{ $cat->libelle }}</td>
          <td class="px-5 py-3 text-right">
            <form action="{{ route('admin.categories-vehicules.destroy', $cat->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression ?')">
              @csrf @method('DELETE')
              <button class="text-red-500 hover:underline text-xs">Supprimer</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="3" class="px-5 py-5 text-center text-gray-500">Aucune catégorie</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Tab Content: Paiements -->
<div id="paiements" class="tab-content hidden">
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
    <h3 class="text-base font-semibold text-gray-800">Modes de paiement enregistrés</h3>
    <button onclick="document.getElementById('modal-type').showModal()" class="text-sm px-4 py-2 bg-[#1D9E75] text-white rounded-lg hover:bg-[#0F6E56] transition">Nouveau mode</button>
  </div>
  <div id="active-paiements-container" class="bg-white border border-gray-100 rounded-2xl overflow-hidden overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 border-b border-gray-100">
        <tr>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">ID</th>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Libellé</th>
          <th class="text-right text-xs text-gray-400 font-normal px-5 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @forelse($types as $type)
        <tr class="hover:bg-gray-50/50">
          <td class="px-5 py-3 text-gray-500">#{{ $type->id }}</td>
          <td class="px-5 py-3 font-medium text-gray-800">{{ $type->libelle }}</td>
          <td class="px-5 py-3 text-right">
            <form action="{{ route('admin.types-paiements.destroy', $type->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression ?')">
              @csrf @method('DELETE')
              <button class="text-red-500 hover:underline text-xs">Supprimer</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="3" class="px-5 py-5 text-center text-gray-500">Aucun type de paiement</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Tab Content: Tarifs -->
<div id="tarifs" class="tab-content hidden">
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
    <h3 class="text-base font-semibold text-gray-800">Grille tarifaire active</h3>
    <button onclick="document.getElementById('modal-tarif').showModal()" class="text-sm px-4 py-2 bg-[#1D9E75] text-white rounded-lg hover:bg-[#0F6E56] transition">Nouveau tarif</button>
  </div>
  <div id="active-tarifs-container" class="bg-white border border-gray-100 rounded-2xl overflow-hidden overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 border-b border-gray-100">
        <tr>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Catégorie</th>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Montant</th>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Valide du</th>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Au</th>
          <th class="text-right text-xs text-gray-400 font-normal px-5 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @forelse($tarifs as $tarif)
        <tr class="hover:bg-gray-50/50">
          <td class="px-5 py-3 font-medium text-gray-800">{{ $tarif->categorieVehicule->libelle ?? 'N/A' }}</td>
          <td class="px-5 py-3 text-gray-600">{{ number_format($tarif->montant, 0, ',', ' ') }} F</td>
          <td class="px-5 py-3 text-gray-500">{{ $tarif->date_debut ? \Carbon\Carbon::parse($tarif->date_debut)->format('d/m/Y') : 'N/A' }}</td>
          <td class="px-5 py-3 text-gray-500">{{ $tarif->date_fin ? \Carbon\Carbon::parse($tarif->date_fin)->format('d/m/Y') : 'Permanent' }}</td>
          <td class="px-5 py-3 text-right">
            <form action="{{ route('admin.tarifs.destroy', $tarif->id) }}" method="POST" class="inline" onsubmit="return confirm('Confirmer la suppression du tarif ?')">
              @csrf @method('DELETE')
              <button class="text-red-500 hover:underline text-xs">Supprimer</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="px-5 py-5 text-center text-gray-500">Aucun tarif défini</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- ================= MODALS ================= -->

<!-- Modal Catégorie -->
<dialog id="modal-categorie" class="backdrop:bg-gray-800/50 p-0 rounded-2xl shadow-xl w-full max-w-md mx-auto bg-white border-0 open:backdrop-blur-sm">
  <div class="p-6">
    <div class="flex justify-between items-center mb-5">
        <h3 class="text-lg font-semibold text-gray-900">Nouvelle catégorie</h3>
        <button type="button" onclick="document.getElementById('modal-categorie').close()" class="text-gray-400 hover:text-gray-600">&times;</button>
    </div>
    <form action="{{ route('admin.categories-vehicules.store') }}" method="POST">
      @csrf
      <div class="mb-5">
          <label class="block text-sm font-medium text-gray-700 mb-1">Libellé</label>
          <input type="text" name="libelle" required placeholder="ex: Voiture légère" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
      </div>
      <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="document.getElementById('modal-categorie').close()" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50">Annuler</button>
          <button type="submit" class="px-4 py-2 bg-[#1D9E75] text-white rounded-lg text-sm hover:bg-[#0F6E56]">Enregistrer</button>
      </div>
    </form>
  </div>
</dialog>

<!-- Modal Type Paiement -->
<dialog id="modal-type" class="backdrop:bg-gray-800/50 p-0 rounded-2xl shadow-xl w-full max-w-md mx-auto bg-white border-0 open:backdrop-blur-sm">
  <div class="p-6">
    <div class="flex justify-between items-center mb-5">
        <h3 class="text-lg font-semibold text-gray-900">Nouveau mode de paiement</h3>
        <button type="button" onclick="document.getElementById('modal-type').close()" class="text-gray-400 hover:text-gray-600">&times;</button>
    </div>
    <form action="{{ route('admin.types-paiements.store') }}" method="POST">
      @csrf
      <div class="mb-5">
          <label class="block text-sm font-medium text-gray-700 mb-1">Libellé</label>
          <input type="text" name="libelle" required placeholder="ex: Espèces" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
      </div>
      <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" onclick="document.getElementById('modal-type').close()" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50">Annuler</button>
          <button type="submit" class="px-4 py-2 bg-[#1D9E75] text-white rounded-lg text-sm hover:bg-[#0F6E56]">Enregistrer</button>
      </div>
    </form>
  </div>
</dialog>

<!-- Modal Tarif -->
<dialog id="modal-tarif" class="backdrop:bg-gray-800/50 p-0 rounded-2xl shadow-xl w-full max-w-md mx-auto bg-white border-0 open:backdrop-blur-sm">
  <div class="p-6">
    <div class="flex justify-between items-center mb-5">
        <h3 class="text-lg font-semibold text-gray-900">Nouveau tarif</h3>
        <button type="button" onclick="document.getElementById('modal-tarif').close()" class="text-gray-400 hover:text-gray-600">&times;</button>
    </div>
    <form action="{{ route('admin.tarifs.store') }}" method="POST" class="space-y-4">
      @csrf
      <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie de véhicule</label>
          <select name="categorie_vehicule_id" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
            <option value="">Sélectionner...</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->libelle }}</option>
            @endforeach
          </select>
      </div>
      <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Montant (F CFA)</label>
          <input type="number" name="montant" min="0" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
      </div>
      <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
            <input type="date" name="date_debut" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
            <input type="date" name="date_fin" title="Facultatif" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
          </div>
      </div>
      <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-2">
          <button type="button" onclick="document.getElementById('modal-tarif').close()" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50">Annuler</button>
          <button type="submit" class="px-4 py-2 bg-[#1D9E75] text-white rounded-lg text-sm hover:bg-[#0F6E56]">Enregistrer</button>
      </div>
    </form>
  </div>
</dialog>
@endsection

@push('scripts')
<script>
function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-link').forEach(el => {
        el.classList.remove('text-[#1D9E75]', 'border-[#1D9E75]', 'font-semibold');
        el.classList.add('text-gray-500', 'border-transparent');
    });
    
    let target = document.getElementById(tabId);
    let link = document.getElementById('link-' + tabId);
    
    if(target && link) {
        target.classList.remove('hidden');
        link.classList.remove('text-gray-500', 'border-transparent');
        link.classList.add('text-[#1D9E75]', 'border-[#1D9E75]', 'font-semibold');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    let activeTab = '{{ session("active_tab", "general") }}';
    switchTab(activeTab);
});
</script>
@endpush
