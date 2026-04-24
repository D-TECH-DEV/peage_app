@extends('layouts.admin')

@section('title', 'Transactions')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
<style>
/* Customizing datatables simple slightly for Tailwind */
.dataTable-input { border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 0.5rem; font-size: 0.875rem; }
.dataTable-selector { border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 0.5rem; font-size: 0.875rem; }
</style>
@endpush

@section('content')
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
  <div>
    <h1 class="text-xl font-semibold text-gray-900">Transactions</h1>
    <p class="text-sm text-gray-500 mt-0.5">Historique complet des passages enregistrés.</p>
  </div>
  <div>
    <button class="text-sm px-4 py-2 bg-[#ccd5ae] text-white rounded-lg hover:bg-[#b0bd89] transition mr-2">Exporter CSV</button>
    <button onclick="document.getElementById('transactionModal').showModal()" class="text-sm px-4 py-2 bg-[#1D9E75] text-white rounded-lg hover:bg-[#0F6E56] transition inline-flex items-center cursor-pointer">
      Nouvelle transaction
    </button>
  </div>
</div>

<!-- Filtres -->
{{-- <div class="flex gap-3 mb-5">
  <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-700 focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
    <option>Tous les véhicules</option>
    <option>Voiture légère</option>
    <option>Camion lourd</option>
    <option>Bus</option>
    <option>Moto</option>
  </select>
  <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-700 focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
    <option>Tous les modes</option>
    <option>Espèces</option>
    <option>Mobile Money</option>
    <option>Carte bancaire</option>
    <option>Abonnement</option>
  </select>
  <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-700 focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
    <option>Tous les guichets</option>
    <option>Guichet 01</option>
    <option>Guichet 02</option>
    <option>Guichet 03</option>
  </select>
  <input type="date" class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-700 focus:outline-none focus:ring-1 focus:ring-[#1D9E75]" />
</div> --}}

<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden mt-5 p-4">
  <div class="overflow-x-auto">
    <table id="transactionsTable" class="w-full text-sm">
      <thead class="bg-gray-50 border-b border-gray-100">
        <tr>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">ID</th>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Date / Heure</th>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3 min-w-[150px]">Type de véhicule</th>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Immatriculation</th>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Guichet</th>
          <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Mode de paiement</th>
          <th class="text-right text-xs text-gray-400 font-normal px-5 py-3">Montant</th>
          <th class="text-right text-xs text-gray-400 font-normal px-5 py-3">Statut</th>
          <th class="text-right text-xs text-gray-400 font-normal px-5 py-3">Agent</th>
          <th class="text-right text-xs text-gray-400 font-normal px-5 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @forelse($paiements as $paiement)
          <tr class="hover:bg-gray-50/50 transition whitespace-nowrap">
              <td class="px-5 py-3 font-mono text-xs text-gray-400">#TX{{ str_pad($paiement->id, 3, '0', STR_PAD_LEFT) }}</td>
              <td class="px-5 py-3 text-gray-600">{{ $paiement->date_paiement ?? $paiement->created_at->format('d M Y — H:i') }}</td>
              <td class="px-5 py-3 text-gray-800">{{ $paiement->categorieVehicule->libelle ?? 'N/A' }}</td>
              <td class="px-5 py-3 text-gray-600">{{ $paiement->immatriculation ?? '-' }}</td>
              <td class="px-5 py-3 text-gray-600">{{ $paiement->guichet->code ?? 'N/A' }}</td>
              <td class="px-5 py-3 text-gray-600">{{ $paiement->typePaiement->libelle ?? 'N/A' }}</td>
              <td class="px-5 py-3 text-right font-medium">{{ number_format($paiement->montant, 0, ',', ' ') }} F</td>
              <td class="px-5 py-3 text-right">
                  @if(($paiement->statut ?? 'Payé') == 'Payé')
                      <span class="pill-green text-[11px] px-2.5 py-0.5 rounded-full">Payé</span>
                  @elseif(($paiement->statut ?? '') == 'En attente')
                      <span class="pill-amber text-[11px] px-2.5 py-0.5 rounded-full">En attente</span>
                  @else
                      <span class="pill-gray text-[11px] px-2.5 py-0.5 rounded-full">{{ $paiement->statut ?? 'Inconnu' }}</span>
                  @endif
              </td>
              <td class="px-5 py-3 text-right text-gray-500">{{ $paiement->user->nom ?? 'N/A' }}</td>
              <td class="px-5 py-3 text-right">
                  <button onclick="printReceipt({{ $paiement->id }})" class="text-gray-500 hover:text-[#1D9E75] transition" title="Imprimer le ticket">
                      <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                  </button>
              </td>
          </tr>
        @empty
        <tr>
          <td colspan="10" class="text-center py-8 text-gray-500">Aucune transaction enregistrée.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const table = document.getElementById("transactionsTable");
    if (table) {
        new simpleDatatables.DataTable(table, {
            searchable: true,
            fixedHeight: false,
            perPage: 10,
            labels: {
                placeholder: "Rechercher...",
                perPage: "transactions par page",
                noRows: "Aucune transaction trouvée",
                info: "Affichage de {start} à {end} sur {rows} transactions"
            }
        });
    }
});

@if(session('print_receipt_id'))
    setTimeout(() => {
        printReceipt({{ session('print_receipt_id') }});
    }, 500);
@endif

function printReceipt(id) {
    const url = "{{ url('admin/paiements') }}/" + id + "/receipt";
    const printWindow = window.open(url, "ReçuPéage", "width=380,height=600,top=100,left=100,toolbar=no,menubar=no,scrollbars=yes,resizable=yes");
    if(printWindow) {
        printWindow.focus();
    } else {
        alert("⚠️ L'impression automatique a été bloquée par votre navigateur. Veuillez autoriser les pop-ups pour ce site.");
    }
}
</script>
@endpush
