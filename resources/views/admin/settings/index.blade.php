@extends('layouts.admin')

@section('title', 'Paramètres')

@section('content')
<div class="mb-6">
  <h1 class="text-xl font-semibold text-gray-900">Paramètres</h1>
  <p class="text-sm text-gray-500 mt-0.5">Configuration de l'application.</p>
</div>
<form action="" method="POST">
  @csrf
  <div class="max-w-xl bg-white border border-gray-100 rounded-2xl p-6 space-y-5">
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
    <button type="button" onclick="alert('Paramètres enregistrés !')" class="bg-[#1D9E75] text-white text-sm px-5 py-2 rounded-lg hover:bg-[#0F6E56] transition">Enregistrer</button>
  </div>
</form>
@endsection
