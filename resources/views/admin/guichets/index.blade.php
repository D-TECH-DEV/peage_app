@extends('layouts.admin')

@section('title', 'Guichets')

@section('content')
<div class="flex items-start justify-between mb-6">
  <div>
    <h1 class="text-xl font-semibold text-gray-900">Guichets</h1>
    <p class="text-sm text-gray-500 mt-0.5">État et performance de chaque guichet de péage.</p>
  </div>
  <div>
    <a href="{{ route('admin.guichets.create') }}" class="text-sm px-4 py-2 bg-[#1D9E75] text-white rounded-lg hover:bg-[#0F6E56] transition inline-flex items-center">
      Nouveau guichet
    </a>
  </div>
</div>

<div class="grid grid-cols-4 gap-4">
  @forelse($guichets as $guichet)
  <!-- Template if dynamic data is present -->
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <div class="flex justify-between items-start mb-3">
      <div>
        <p class="font-medium text-gray-800">{{ $guichet->libelle }}</p>
        <p class="text-xs text-gray-400">{{ $guichet->type }}</p>
      </div>
      <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">Actif</span>
    </div>
    <div class="mt-4 flex gap-2">
      <a href="{{ route('admin.guichets.edit', $guichet->id) }}" class="text-xs text-blue-600 hover:underline">Modifier</a>
    </div>
  </div>
  @empty
  <!-- Fallback static data from HTML prototype -->
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <div class="flex justify-between items-start mb-3">
      <div><p class="font-medium text-gray-800">Guichet 01</p><p class="text-xs text-gray-400">Nord — Entrée</p></div>
      <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">Actif</span>
    </div>
    <p class="text-xl font-semibold text-gray-900 mb-1">920 000 F</p>
    <p class="text-xs text-gray-400 mb-3">1 842 passages ce mois</p>
    <div class="text-xs text-gray-500 border-t border-gray-50 pt-3">Agent: <span class="text-gray-700 font-medium">Kouadio B.</span></div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <div class="flex justify-between items-start mb-3">
      <div><p class="font-medium text-gray-800">Guichet 02</p><p class="text-xs text-gray-400">Nord — Sortie</p></div>
      <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">Actif</span>
    </div>
    <p class="text-xl font-semibold text-gray-900 mb-1">810 000 F</p>
    <p class="text-xs text-gray-400 mb-3">1 620 passages ce mois</p>
    <div class="text-xs text-gray-500 border-t border-gray-50 pt-3">Agent: <span class="text-gray-700 font-medium">Traoré M.</span></div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <div class="flex justify-between items-start mb-3">
      <div><p class="font-medium text-gray-800">Guichet 03</p><p class="text-xs text-gray-400">Sud — Entrée</p></div>
      <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">Actif</span>
    </div>
    <p class="text-xl font-semibold text-gray-900 mb-1">740 000 F</p>
    <p class="text-xs text-gray-400 mb-3">1 480 passages ce mois</p>
    <div class="text-xs text-gray-500 border-t border-gray-50 pt-3">Agent: <span class="text-gray-700 font-medium">Diallo A.</span></div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <div class="flex justify-between items-start mb-3">
      <div><p class="font-medium text-gray-800">Guichet 04</p><p class="text-xs text-gray-400">Sud — Sortie</p></div>
      <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">Actif</span>
    </div>
    <p class="text-xl font-semibold text-gray-900 mb-1">680 000 F</p>
    <p class="text-xs text-gray-400 mb-3">1 360 passages ce mois</p>
    <div class="text-xs text-gray-500 border-t border-gray-50 pt-3">Agent: <span class="text-gray-700 font-medium">Ouédraogo F.</span></div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <div class="flex justify-between items-start mb-3">
      <div><p class="font-medium text-gray-800">Guichet 05</p><p class="text-xs text-gray-400">Est — Entrée</p></div>
      <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">Actif</span>
    </div>
    <p class="text-xl font-semibold text-gray-900 mb-1">590 000 F</p>
    <p class="text-xs text-gray-400 mb-3">1 180 passages ce mois</p>
    <div class="text-xs text-gray-500 border-t border-gray-50 pt-3">Agent: <span class="text-gray-700 font-medium">Coulibaly N.</span></div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5">
    <div class="flex justify-between items-start mb-3">
      <div><p class="font-medium text-gray-800">Guichet 06</p><p class="text-xs text-gray-400">Est — Sortie</p></div>
      <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">Actif</span>
    </div>
    <p class="text-xl font-semibold text-gray-900 mb-1">540 000 F</p>
    <p class="text-xs text-gray-400 mb-3">1 080 passages ce mois</p>
    <div class="text-xs text-gray-500 border-t border-gray-50 pt-3">Agent: <span class="text-gray-700 font-medium">Bamba K.</span></div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5 opacity-50">
    <div class="flex justify-between items-start mb-3">
      <div><p class="font-medium text-gray-800">Guichet 07</p><p class="text-xs text-gray-400">Ouest — Entrée</p></div>
      <span class="pill-gray text-[10px] px-2 py-0.5 rounded-full">Inactif</span>
    </div>
    <p class="text-xl font-semibold text-gray-900 mb-1">— F</p>
    <p class="text-xs text-gray-400 mb-3">Fermé ce mois</p>
    <div class="text-xs text-gray-500 border-t border-gray-50 pt-3">Agent: <span class="text-gray-700 font-medium">Non assigné</span></div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5 opacity-50">
    <div class="flex justify-between items-start mb-3">
      <div><p class="font-medium text-gray-800">Guichet 08</p><p class="text-xs text-gray-400">Ouest — Sortie</p></div>
      <span class="pill-gray text-[10px] px-2 py-0.5 rounded-full">Inactif</span>
    </div>
    <p class="text-xl font-semibold text-gray-900 mb-1">— F</p>
    <p class="text-xs text-gray-400 mb-3">Fermé ce mois</p>
    <div class="text-xs text-gray-500 border-t border-gray-50 pt-3">Agent: <span class="text-gray-700 font-medium">Non assigné</span></div>
  </div>
  @endforelse
</div>
@endsection
