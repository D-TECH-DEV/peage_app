@extends('layouts.admin')

@section('title', 'Transactions')

@section('content')
<div class="flex items-start justify-between mb-6">
  <div>
    <h1 class="text-xl font-semibold text-gray-900">Transactions</h1>
    <p class="text-sm text-gray-500 mt-0.5">Historique complet des passages enregistrés.</p>
  </div>
  <div>
    <button class="text-sm px-4 py-2 bg-[#ccd5ae] text-white rounded-lg hover:bg-[#b0bd89] transition mr-2">Exporter CSV</button>
    <a href="{{ route('admin.paiements.create') }}" class="text-sm px-4 py-2 bg-[#1D9E75] text-white rounded-lg hover:bg-[#0F6E56] transition inline-flex items-center">
      Nouvelle transaction
    </a>
  </div>
</div>

<!-- Filtres -->
<div class="flex gap-3 mb-5">
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
</div>

<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-gray-50 border-b border-gray-100">
      <tr>
        <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">ID</th>
        <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Date / Heure</th>
        <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Type de véhicule</th>
        <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Guichet</th>
        <th class="text-left text-xs text-gray-400 font-normal px-5 py-3">Mode de paiement</th>
        <th class="text-right text-xs text-gray-400 font-normal px-5 py-3">Montant</th>
        <th class="text-right text-xs text-gray-400 font-normal px-5 py-3">Statut</th>
        <th class="text-right text-xs text-gray-400 font-normal px-5 py-3">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-50">
      @forelse($paiements as $paiement)
        <!-- Code using actual variable if injected -->
      @empty
        <!-- Fallback static data from HTML prototype -->
        <tr class="hover:bg-gray-50/50 transition"><td class="px-5 py-3 font-mono text-xs text-gray-400">#TX001</td><td class="px-5 py-3 text-gray-600">23 Avr. 2025 — 07:14</td><td class="px-5 py-3 text-gray-800">Camion lourd</td><td class="px-5 py-3 text-gray-600">G-02</td><td class="px-5 py-3 text-gray-600">Espèces</td><td class="px-5 py-3 text-right font-medium">2 500 F</td><td class="px-5 py-3 text-right"><span class="pill-green text-[11px] px-2.5 py-0.5 rounded-full">Payé</span></td><td class="px-5 py-3 text-right"></td></tr>
        <tr class="hover:bg-gray-50/50 transition"><td class="px-5 py-3 font-mono text-xs text-gray-400">#TX002</td><td class="px-5 py-3 text-gray-600">23 Avr. 2025 — 07:28</td><td class="px-5 py-3 text-gray-800">Voiture légère</td><td class="px-5 py-3 text-gray-600">G-01</td><td class="px-5 py-3 text-gray-600">Mobile Money</td><td class="px-5 py-3 text-right font-medium">500 F</td><td class="px-5 py-3 text-right"><span class="pill-green text-[11px] px-2.5 py-0.5 rounded-full">Payé</span></td><td class="px-5 py-3 text-right"></td></tr>
        <tr class="hover:bg-gray-50/50 transition"><td class="px-5 py-3 font-mono text-xs text-gray-400">#TX003</td><td class="px-5 py-3 text-gray-600">23 Avr. 2025 — 07:45</td><td class="px-5 py-3 text-gray-800">Bus</td><td class="px-5 py-3 text-gray-600">G-04</td><td class="px-5 py-3 text-gray-600">Carte bancaire</td><td class="px-5 py-3 text-right font-medium">1 500 F</td><td class="px-5 py-3 text-right"><span class="pill-green text-[11px] px-2.5 py-0.5 rounded-full">Payé</span></td><td class="px-5 py-3 text-right"></td></tr>
        <tr class="hover:bg-gray-50/50 transition"><td class="px-5 py-3 font-mono text-xs text-gray-400">#TX004</td><td class="px-5 py-3 text-gray-600">23 Avr. 2025 — 08:03</td><td class="px-5 py-3 text-gray-800">Moto</td><td class="px-5 py-3 text-gray-600">G-03</td><td class="px-5 py-3 text-gray-600">Espèces</td><td class="px-5 py-3 text-right font-medium">200 F</td><td class="px-5 py-3 text-right"><span class="pill-amber text-[11px] px-2.5 py-0.5 rounded-full">En attente</span></td><td class="px-5 py-3 text-right"></td></tr>
        <tr class="hover:bg-gray-50/50 transition"><td class="px-5 py-3 font-mono text-xs text-gray-400">#TX005</td><td class="px-5 py-3 text-gray-600">23 Avr. 2025 — 08:19</td><td class="px-5 py-3 text-gray-800">Camion léger</td><td class="px-5 py-3 text-gray-600">G-05</td><td class="px-5 py-3 text-gray-600">Espèces</td><td class="px-5 py-3 text-right font-medium">1 500 F</td><td class="px-5 py-3 text-right"><span class="pill-green text-[11px] px-2.5 py-0.5 rounded-full">Payé</span></td><td class="px-5 py-3 text-right"></td></tr>
        <tr class="hover:bg-gray-50/50 transition"><td class="px-5 py-3 font-mono text-xs text-gray-400">#TX006</td><td class="px-5 py-3 text-gray-600">23 Avr. 2025 — 08:34</td><td class="px-5 py-3 text-gray-800">Voiture légère</td><td class="px-5 py-3 text-gray-600">G-02</td><td class="px-5 py-3 text-gray-600">Mobile Money</td><td class="px-5 py-3 text-right font-medium">500 F</td><td class="px-5 py-3 text-right"><span class="pill-red text-[11px] px-2.5 py-0.5 rounded-full">Annulé</span></td><td class="px-5 py-3 text-right"></td></tr>
        <tr class="hover:bg-gray-50/50 transition"><td class="px-5 py-3 font-mono text-xs text-gray-400">#TX007</td><td class="px-5 py-3 text-gray-600">23 Avr. 2025 — 08:51</td><td class="px-5 py-3 text-gray-800">Bus</td><td class="px-5 py-3 text-gray-600">G-06</td><td class="px-5 py-3 text-gray-600">Abonnement</td><td class="px-5 py-3 text-right font-medium">0 F</td><td class="px-5 py-3 text-right"><span class="pill-blue text-[11px] px-2.5 py-0.5 rounded-full">Abonné</span></td><td class="px-5 py-3 text-right"></td></tr>
      @endforelse
    </tbody>
  </table>
  @if(isset($paiements) && method_exists($paiements, 'links'))
    <div class="px-5 py-3 border-t border-gray-100">
      {{ $paiements->links() }}
    </div>
  @endif
</div>
@endsection
