@extends('layouts.admin')

@section('title', 'Rapports')

@section('content')
<div class="mb-6">
  <h1 class="text-xl font-semibold text-gray-900">Rapports</h1>
  <p class="text-sm text-gray-500 mt-0.5">Analyse détaillée des recettes et performances.</p>
</div>
<div class="grid grid-cols-2 gap-4 mb-5">
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <h3 class="text-sm font-medium text-gray-800 mb-4">Recettes par type de véhicule</h3>
    <div class="relative h-56"><canvas id="chartRapportVehicule"></canvas></div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <h3 class="text-sm font-medium text-gray-800 mb-4">Évolution mensuelle — 6 mois</h3>
    <div class="relative h-56"><canvas id="chartRapportMois"></canvas></div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  new Chart(document.getElementById('chartRapportVehicule'), {
    type: 'bar',
    data: {
      labels: ['Voiture légère', 'Camion lourd', 'Bus', 'Camion léger', 'Moto'],
      datasets: [{
        label: 'Recettes (k F)',
        data: [1800, 940, 642, 558, 340],
        backgroundColor: ['#1D9E75', '#0F6E56', '#378ADD', '#BA7517', '#9CA3AF'],
        borderRadius: 6,
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

  new Chart(document.getElementById('chartRapportMois'), {
    type: 'line',
    data: {
      labels: ['Nov', 'Déc', 'Jan', 'Fév', 'Mar', 'Avr'],
      datasets: [{
        label: 'Recettes (M F)',
        data: [3.2, 3.5, 3.8, 3.6, 4.0, 4.28],
        borderColor: '#1D9E75',
        backgroundColor: 'rgba(29,158,117,0.08)',
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#1D9E75',
        pointRadius: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#9CA3AF' } },
        y: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 10 }, color: '#9CA3AF', callback: v => v + 'M' } }
      }
    }
  });
</script>
@endpush
