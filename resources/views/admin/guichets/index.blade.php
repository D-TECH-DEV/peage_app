@extends('layouts.admin')

@section('title', 'Guichets')

@section('content')
<div class="flex items-start justify-between mb-6">
  <div>
    <h1 class="text-xl font-semibold text-gray-900">Guichets</h1>
    <p class="text-sm text-gray-500 mt-0.5">Gestion et état de chaque guichet de péage.</p>
  </div>
  <div>
    <button onclick="document.getElementById('modal-create-guichet').showModal()" class="text-sm px-4 py-2 bg-[#1D9E75] text-white rounded-lg hover:bg-[#0F6E56] transition inline-flex items-center">
      Nouveau guichet
    </button>
  </div>
</div>

<div class="grid grid-cols-4 gap-4">
  @forelse($guichets as $guichet)
  <div class="bg-white border border-gray-100 rounded-2xl p-5 {{ ($guichet->statut == 'Inactif') ? 'opacity-60' : '' }}">
    <div class="flex justify-between items-start mb-3">
      <div>
        <p class="font-semibold text-gray-800">{{ $guichet->code ?: 'Sans code' }}</p>
      </div>
      @if($guichet->statut == 'Inactif')
        <span class="pill-gray text-[10px] px-2 py-0.5 rounded-full">Inactif</span>
      @else
        <span class="pill-green text-[10px] px-2 py-0.5 rounded-full">Actif</span>
      @endif
    </div>
    
    <!-- Dummy data for aesthetics to match UI prototype -->
    <p class="text-xl font-semibold text-gray-900 mb-1">0 F</p>
    <p class="text-xs text-gray-400 mb-3">0 passage ce mois</p>

    <div class="text-xs flex gap-3 border-t border-gray-50 pt-3 mt-3">
      <button onclick="document.getElementById('modal-edit-guichet-{{ $guichet->id }}').showModal()" class="text-blue-600 hover:underline">Modifier</button>
      <form action="{{ route('admin.guichets.destroy', $guichet->id) }}" method="POST" onsubmit="return confirm('Vraiment supprimer ce guichet ?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
      </form>
    </div>
  </div>

  <!-- Edit Modal for this specific Guichet -->
  <dialog id="modal-edit-guichet-{{ $guichet->id }}" class="backdrop:bg-gray-800/50 p-0 rounded-2xl shadow-xl w-full max-w-md mx-auto bg-white border-0 open:backdrop-blur-sm">
    <div class="p-6">
      <div class="flex justify-between items-center mb-5">
          <h3 class="text-lg font-semibold text-gray-900">Modifier le guichet</h3>
          <button type="button" onclick="document.getElementById('modal-edit-guichet-{{ $guichet->id }}').close()" class="text-gray-400 hover:text-gray-600">&times;</button>
      </div>
      <form action="{{ route('admin.guichets.update', $guichet->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Code / Nom</label>
            <input type="text" name="code" value="{{ $guichet->code }}" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select name="statut" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
                <option value="Actif" {{ $guichet->statut == 'Actif' ? 'selected' : '' }}>Actif</option>
                <option value="Inactif" {{ $guichet->statut == 'Inactif' ? 'selected' : '' }}>Inactif</option>
            </select>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-2">
            <button type="button" onclick="document.getElementById('modal-edit-guichet-{{ $guichet->id }}').close()" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50">Annuler</button>
            <button type="submit" class="px-4 py-2 bg-[#1D9E75] text-white rounded-lg text-sm hover:bg-[#0F6E56]">Mettre à jour</button>
        </div>
      </form>
    </div>
  </dialog>

  @empty
  <div class="col-span-4 p-8 text-center bg-white border border-gray-100 rounded-2xl">
      <p class="text-gray-500">Aucun guichet configuré.</p>
  </div>
  @endforelse
</div>

<!-- Create Modal -->
<dialog id="modal-create-guichet" class="backdrop:bg-gray-800/50 p-0 rounded-2xl shadow-xl w-full max-w-md mx-auto bg-white border-0 open:backdrop-blur-sm">
  <div class="p-6">
    <div class="flex justify-between items-center mb-5">
        <h3 class="text-lg font-semibold text-gray-900">Nouveau guichet</h3>
        <button type="button" onclick="document.getElementById('modal-create-guichet').close()" class="text-gray-400 hover:text-gray-600">&times;</button>
    </div>
    <form action="{{ route('admin.guichets.store') }}" method="POST" class="space-y-4">
      @csrf
      
      <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Code / Nom</label>
          <input type="text" name="code" placeholder="ex: Guichet 01 - Nord" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
      </div>
      
      <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
          <select name="statut" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
              <option value="Actif">Actif</option>
              <option value="Inactif">Inactif</option>
          </select>
      </div>

      <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-2">
          <button type="button" onclick="document.getElementById('modal-create-guichet').close()" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50">Annuler</button>
          <button type="submit" class="px-4 py-2 bg-[#1D9E75] text-white rounded-lg text-sm hover:bg-[#0F6E56]">Créer</button>
      </div>
    </form>
  </div>
</dialog>
@endsection
