@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
  <div>
    <h1 class="text-xl font-semibold text-gray-900">Tableau de bord</h1>
    <p class="text-sm text-gray-500 mt-0.5">Suivre, analyser et optimiser les recettes du péage.</p>
  </div>
  <div class="flex items-center gap-2">
    <button class="text-sm px-4 py-2 border border-gray-200 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition">Exporter</button>
    
    <a href="{{ route('admin.paiements.create') }}" class="text-sm px-4 py-2 bg-[#1D9E75] text-white rounded-lg hover:bg-[#0F6E56] transition flex items-center gap-2 inline-flex">
      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
      Nouveau passage
    </a>
  </div>
</div>

<!-- Stat cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
  <div class="bg-[#E1F5EE] border border-[#9FE1CB] rounded-2xl p-4">
    <p class="text-xs text-[#0F6E56] mb-1">Recettes du mois</p>
    <p class="text-2xl font-semibold text-[#085041]">{{ number_format($recettesMois, 0, ',', ' ') }} F</p>
    <span class="inline-flex items-center gap-1 text-[11px] mt-2 bg-[#9FE1CB] text-[#085041] px-2 py-0.5 rounded-full">
      {!! $percentChange >= 0 ? "↑ +{$percentChange}% vs mois dernier" : "↓ {$percentChange}% vs mois dernier" !!}
    </span>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-4">
    <p class="text-xs text-gray-500 mb-1">Total passages</p>
    <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalPassagesMois, 0, ',', ' ') }}</p>
    <span class="inline-flex items-center text-[11px] mt-2 bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Ce mois</span>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-4">
    <p class="text-xs text-gray-500 mb-1">Guichets actifs</p>
    <p class="text-2xl font-semibold text-gray-900">{{ $guichetsActifs }} / {{ $totalGuichets }}</p>
    <span class="inline-flex items-center text-[11px] mt-2 bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Opérationnels</span>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-4">
    <p class="text-xs text-gray-500 mb-1">Recette moyenne/jour</p>
    <p class="text-2xl font-semibold text-gray-900">{{ number_format($recetteMoyenneJour, 0, ',', ' ') }} F</p>
    <span class="inline-flex items-center text-[11px] mt-2 bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ now()->translatedFormat('F Y') }}</span>
  </div>
</div>

<!-- Charts row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-5">
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-sm font-medium text-gray-800">Rendement mensuel (F CFA)</h3>
      <span class="text-xs text-gray-400">Avril 2025</span>
    </div>
    <div class="relative h-44">
      <canvas id="chartRendement"></canvas>
    </div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-sm font-medium text-gray-800">Types de véhicules</h3>
      <span class="text-xs text-gray-400">Ce mois</span>
    </div>
    <div class="relative h-44">
      <canvas id="chartVehicules"></canvas>
    </div>
  </div>
</div>

<!-- Bottom row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

  <!-- Transactions table -->
  <div class="lg:col-span-1 bg-white border border-gray-100 rounded-2xl p-5">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-sm font-medium text-gray-800">Transactions récentes</h3>
      <span class="text-xs text-gray-400">Aujourd'hui</span>
    </div>
    <table class="w-full text-xs">
      <thead>
        <tr class="border-b border-gray-100">
          <th class="text-left text-gray-400 font-normal pb-2">Véhicule</th>
          <th class="text-left text-gray-400 font-normal pb-2">Guichet</th>
          <th class="text-left text-gray-400 font-normal pb-2">Mode</th>
          <th class="text-right text-gray-400 font-normal pb-2">Statut</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @forelse($recentTransactions as $tx)
        <tr>
            <td class="py-2 text-gray-700">{{ $tx->categorieVehicule->libelle ?? '-' }}</td>
            <td class="text-gray-500">{{ $tx->guichet->code ?? '-' }}</td>
            <td class="text-gray-500">{{ $tx->typePaiement->libelle ?? '-' }}</td>
            <td class="text-right">
                @if($tx->statut == 'Payé')
                    <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">Payé</span>
                @elseif($tx->statut == 'En attente')
                    <span class="pill-amber text-[10px] px-2 py-0.5 rounded-full">Attente</span>
                @else
                    <span class="pill-red text-[10px] px-2 py-0.5 rounded-full">{{ $tx->statut ?? 'Annulé' }}</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center py-4 text-gray-500 text-xs">Aucune transaction récente</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Mode paiement -->
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-sm font-medium text-gray-800">Modes de paiement</h3>
      <span class="text-xs text-gray-400">Ce mois</span>
    </div>
    <div class="space-y-3">
      @foreach($modesStats as $stat)
      <div class="flex items-center justify-between text-sm">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $stat['color'] }}"></span>
            <span class="text-gray-600">{{ $stat['libelle'] }}</span>
        </div>
        <div class="flex items-center gap-3">
          <div class="w-24 bg-gray-100 rounded-full h-1.5">
              <div class="h-1.5 rounded-full" style="width:{{ $stat['percent'] }}%; background-color: {{ $stat['color'] }}"></div>
          </div>
          <span class="font-medium text-gray-800 w-8 text-right">{{ $stat['percent'] }}%</span>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Timer session -->
    <div class="mt-5 bg-[#085041] rounded-xl p-4">
      <p class="text-xs text-[#9FE1CB] mb-1">Session en cours</p>
      <p class="font-mono text-2xl font-medium text-white" id="timer">00:00:00</p>
      <p class="text-[11px] text-[#9FE1CB] mt-1">{{ $currentGuichet->code ?? 'Autre' }} — Agent: {{ auth()->user()->nom ?? 'N/A' }}</p>
      <div class="flex gap-2 mt-3">
        <button class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center hover:bg-white/25 transition" title="Pause">
          <svg class="w-3.5 h-3.5 fill-white" viewBox="0 0 24 24"><path d="M6 4h4v16H6zM14 4h4v16h-4z"/></svg>
        </button>
        <button class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center hover:bg-white/25 transition" title="Arrêter">
          <svg class="w-3.5 h-3.5 fill-white" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2"/></svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Guichets -->
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-sm font-medium text-gray-800">Performance Guichets</h3>
      <span class="text-xs text-gray-400">Recettes</span>
    </div>
    <div class="space-y-4">
      @foreach($performancesGuichets as $guichet)
      <div>
        <div class="flex justify-between text-xs mb-1">
            <span class="font-medium text-gray-700">{{ $guichet->code }}</span>
            @if($guichet->statut == 'Inactif')
                <span class="pill-gray px-2 py-0.5 rounded-full text-[10px]">Inactif</span>
            @endif
            <span class="text-gray-500">{{ number_format($guichet->paiements_sum_montant, 0, ',', ' ') }} F</span>
        </div>
        <div class="bg-gray-100 rounded-full h-1.5">
            <div class="bg-[#1D9E75] h-1.5 rounded-full progress-fill" style="width:{{ $guichet->percent }}%; {{ $guichet->statut == 'Inactif' ? 'background-color:#9CA3AF' : '' }}"></div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // ─── Timer session ───────────────────────────────────────────────────────────
  let seconds = 8 * 3600 + 14 * 60 + 32;
  const timerEl = document.getElementById('timer');

  function updateTimer() {
    seconds++;
    const h   = String(Math.floor(seconds / 3600)).padStart(2, '0');
    const m   = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
    const sec = String(seconds % 60).padStart(2, '0');
    if (timerEl) timerEl.textContent = `${h}:${m}:${sec}`;
  }
  setInterval(updateTimer, 1000);

  // ─── Graphique rendement journalier ─────────────────────────────────────────
  const days     = {!! json_encode($rendementLabels) !!};
  const recettes = {!! json_encode($rendementData) !!};

  new Chart(document.getElementById('chartRendement'), {
    type: 'bar',
    data: {
      labels: days,
      datasets: [{
        label: 'Recettes (k F)',
        data: recettes,
        backgroundColor: recettes.map(v => v > 0 ? '#1D9E75' : '#9FE1CB'),
        borderRadius: 5,
        borderSkipped: false
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#9CA3AF' } },
        y: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 10 }, color: '#9CA3AF', callback: v => v + 'k' } }
      }
    }
  });

  // ─── Graphique types de véhicules ────────────────────────────────────────────
  const vehiculesLabels = {!! json_encode($vehiculesLabels) !!};
  const vehiculesData   = {!! json_encode($vehiculesData) !!};

  new Chart(document.getElementById('chartVehicules'), {
    type: 'doughnut',
    data: {
      labels: vehiculesLabels,
      datasets: [{
        data: vehiculesData,
        backgroundColor: ['#1D9E75', '#0F6E56', '#378ADD', '#BA7517', '#9CA3AF', '#5DCAA5'],
        borderWidth: 2,
        borderColor: '#fff'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '65%',
      plugins: {
        legend: {
          position: 'right',
          labels: { font: { size: 10 }, boxWidth: 10, padding: 8, color: '#6B7280' }
        }
      }
    }
  });
</script>
@endpush
