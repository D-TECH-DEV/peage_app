@extends('layouts.admin')

@section('title', 'Agents')

@section('content')
<div class="mb-6 flex justify-between items-center">
  <div>
    <h1 class="text-xl font-semibold text-gray-900">Agents</h1>
    <p class="text-sm text-gray-500 mt-0.5">Gestion du personnel affecté aux guichets.</p>
  </div>
  <div>
    <button onclick="document.getElementById('modal-create-user').showModal()" class="text-sm px-4 py-2 bg-[#1D9E75] text-white rounded-lg hover:bg-[#0F6E56] transition inline-flex items-center">
      Nouvel Agent
    </button>
  </div>
</div>
<div class="grid grid-cols-3 gap-4">
  @forelse($users as $user)
    <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-start gap-4">
      <div class="w-10 h-10 rounded-full bg-[#E1F5EE] flex items-center justify-center text-[#0F6E56] font-semibold text-sm flex-shrink-0">
        {{ strtoupper(substr($user->nom ?? $user->name ?? 'A', 0, 1)) }}{{ strtoupper(substr($user->prenoms ?? '', 0, 1)) }}
      </div>
      <div class="flex-1">
        <div class="flex justify-between items-start">
            <p class="font-medium text-gray-800">{{ $user->nom ?? '' }} {{ $user->prenoms ?? '' }}</p>
        </div>
        <p class="text-xs text-gray-400 mb-3">{{ $user->email }}</p>
        
        <div class="flex gap-3 text-xs border-t border-gray-50 pt-3 mt-1">
            <button onclick="document.getElementById('modal-edit-user-{{ $user->id }}').showModal()" class="text-blue-600 hover:underline">Modifier</button>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression de cet agent ?')">
                @csrf @method('DELETE')
                <button class="text-red-500 hover:underline">Supprimer</button>
            </form>
        </div>
      </div>
    </div>

    <!-- Edit Modal for User -->
    <dialog id="modal-edit-user-{{ $user->id }}" class="backdrop:bg-gray-800/50 p-0 rounded-2xl shadow-xl w-full max-w-md mx-auto bg-white border-0 open:backdrop-blur-sm">
      <div class="p-6">
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-lg font-semibold text-gray-900">Modifier l'agent</h3>
            <button type="button" onclick="document.getElementById('modal-edit-user-{{ $user->id }}').close()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
          @csrf @method('PUT')
          <div class="grid grid-cols-2 gap-4">
              <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                  <input type="text" name="nom" value="{{ $user->nom }}" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
              </div>
              <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Prénoms</label>
                  <input type="text" name="prenoms" value="{{ $user->prenoms }}" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
              </div>
          </div>
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input type="email" name="email" value="{{ $user->email }}" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
          </div>
          <div class="grid grid-cols-2 gap-4">
              <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe <span class="text-gray-400 font-normal">(optionnel)</span></label>
                  <input type="password" name="password" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
              </div>
              <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer mot de passe</label>
                  <input type="password" name="password_confirmation" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
              </div>
          </div>
          <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-2">
              <button type="button" onclick="document.getElementById('modal-edit-user-{{ $user->id }}').close()" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50">Annuler</button>
              <button type="submit" class="px-4 py-2 bg-[#1D9E75] text-white rounded-lg text-sm hover:bg-[#0F6E56]">Mettre à jour</button>
          </div>
        </form>
      </div>
    </dialog>

  @empty
  <div class="col-span-3 p-8 text-center bg-white border border-gray-100 rounded-2xl">
      <p class="text-gray-500">Aucun agent configuré.</p>
  </div>
  @endforelse
</div>

<!-- Create Modal for User -->
<dialog id="modal-create-user" class="backdrop:bg-gray-800/50 p-0 rounded-2xl shadow-xl w-full max-w-md mx-auto bg-white border-0 open:backdrop-blur-sm">
  <div class="p-6">
    <div class="flex justify-between items-center mb-5">
        <h3 class="text-lg font-semibold text-gray-900">Nouvel agent</h3>
        <button type="button" onclick="document.getElementById('modal-create-user').close()" class="text-gray-400 hover:text-gray-600">&times;</button>
    </div>
    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
      @csrf
      <div class="grid grid-cols-2 gap-4">
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
              <input type="text" name="nom" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
          </div>
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Prénoms</label>
              <input type="text" name="prenoms" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
          </div>
      </div>
      <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input type="email" name="email" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
      </div>
      <div class="grid grid-cols-2 gap-4">
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
              <input type="password" name="password" required minlength="8" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
          </div>
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer mot de passe</label>
              <input type="password" name="password_confirmation" required minlength="8" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1D9E75]">
          </div>
      </div>
      <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-2">
          <button type="button" onclick="document.getElementById('modal-create-user').close()" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50">Annuler</button>
          <button type="submit" class="px-4 py-2 bg-[#1D9E75] text-white rounded-lg text-sm hover:bg-[#0F6E56]">Créer</button>
      </div>
    </form>
  </div>
</dialog>
@endsection
