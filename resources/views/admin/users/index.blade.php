@extends('layouts.admin')

@section('title', 'Agents')

@section('content')
<div class="mb-6 flex justify-between items-center">
  <div>
    <h1 class="text-xl font-semibold text-gray-900">Agents</h1>
    <p class="text-sm text-gray-500 mt-0.5">Gestion du personnel affecté aux guichets.</p>
  </div>
  <div>
    <a href="{{ route('admin.users.create') }}" class="text-sm px-4 py-2 bg-[#1D9E75] text-white rounded-lg hover:bg-[#0F6E56] transition inline-flex items-center">
      Nouvel Agent
    </a>
  </div>
</div>
<div class="grid grid-cols-3 gap-4">
  @forelse($users as $user)
    <!-- Use DB data -->
    <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
      <div class="w-10 h-10 rounded-full bg-[#E1F5EE] flex items-center justify-center text-[#0F6E56] font-semibold text-sm flex-shrink-0">
        {{ strtoupper(substr($user->name, 0, 2)) }}
      </div>
      <div>
        <p class="font-medium text-gray-800">{{ $user->name }}</p>
        <p class="text-xs text-gray-400 mb-2">{{ $user->email }}</p>
        <div class="flex gap-2">
            <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">{{ $user->role ?? 'Agent' }}</span>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-xs text-blue-600 hover:underline">Modifier</a>
        </div>
      </div>
    </div>
  @empty
  <!-- Fallback static HTML -->
  <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
    <div class="w-10 h-10 rounded-full bg-[#E1F5EE] flex items-center justify-center text-[#0F6E56] font-semibold text-sm flex-shrink-0">KB</div>
    <div>
      <p class="font-medium text-gray-800">Kouadio Bernard</p>
      <p class="text-xs text-gray-400 mb-2">Guichet 01 — Nord Entrée</p>
      <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">En service</span>
    </div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
    <div class="w-10 h-10 rounded-full bg-[#E6F1FB] flex items-center justify-center text-[#185FA5] font-semibold text-sm flex-shrink-0">TM</div>
    <div>
      <p class="font-medium text-gray-800">Traoré Mamadou</p>
      <p class="text-xs text-gray-400 mb-2">Guichet 02 — Nord Sortie</p>
      <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">En service</span>
    </div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
    <div class="w-10 h-10 rounded-full bg-[#FAEEDA] flex items-center justify-center text-[#854F0B] font-semibold text-sm flex-shrink-0">DA</div>
    <div>
      <p class="font-medium text-gray-800">Diallo Aminata</p>
      <p class="text-xs text-gray-400 mb-2">Guichet 03 — Sud Entrée</p>
      <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">En service</span>
    </div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
    <div class="w-10 h-10 rounded-full bg-[#FCEBEB] flex items-center justify-center text-[#A32D2D] font-semibold text-sm flex-shrink-0">OF</div>
    <div>
      <p class="font-medium text-gray-800">Ouédraogo Fatou</p>
      <p class="text-xs text-gray-400 mb-2">Guichet 04 — Sud Sortie</p>
      <span class="pill-amber text-[10px] px-2 py-0.5 rounded-full">Pause</span>
    </div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
    <div class="w-10 h-10 rounded-full bg-[#E1F5EE] flex items-center justify-center text-[#0F6E56] font-semibold text-sm flex-shrink-0">CN</div>
    <div>
      <p class="font-medium text-gray-800">Coulibaly Noël</p>
      <p class="text-xs text-gray-400 mb-2">Guichet 05 — Est Entrée</p>
      <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">En service</span>
    </div>
  </div>
  <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
    <div class="w-10 h-10 rounded-full bg-[#E6F1FB] flex items-center justify-center text-[#185FA5] font-semibold text-sm flex-shrink-0">BK</div>
    <div>
      <p class="font-medium text-gray-800">Bamba Kofi</p>
      <p class="text-xs text-gray-400 mb-2">Guichet 06 — Est Sortie</p>
      <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">En service</span>
    </div>
  </div>
  @endforelse
</div>
@endsection
