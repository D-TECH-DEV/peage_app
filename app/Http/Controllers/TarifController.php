<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use App\Models\CategorieVehicule;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifs = Tarif::with('categorieVehicule')->get();
        return view('admin.tarifs.index', compact('tarifs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategorieVehicule::all();
        return view('admin.tarifs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'categorie_vehicule_id' => 'required|exists:categorie_vehicule,id',
            'montant' => 'required|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ], [
            'categorie_vehicule_id.required' => 'La catégorie de véhicule est obligatoire.',
            'categorie_vehicule_id.exists' => 'La catégorie sélectionnée est invalide.',
            'montant.required' => 'Le montant du tarif est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.min' => 'Le montant doit être au moins 0.',
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.date' => 'La date de début doit être une date valide.',
            'date_fin.date' => 'La date de fin doit être une date valide.',
            'date_fin.after_or_equal' => 'La date de fin doit être après ou égale à la date de début.',
        ]);

        Tarif::create($request->all());

        return redirect()->route('admin.tarifs.index')
            ->with('success', 'Tarif créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tarif = Tarif::with('categorieVehicule')->findOrFail($id);
        return view('admin.tarifs.show', compact('tarif'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tarif = Tarif::findOrFail($id);
        $categories = CategorieVehicule::all();
        return view('admin.tarifs.edit', compact('tarif', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'categorie_vehicule_id' => 'required|exists:categorie_vehicule,id',
            'montant' => 'required|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ], [
            'categorie_vehicule_id.required' => 'La catégorie de véhicule est obligatoire.',
            'categorie_vehicule_id.exists' => 'La catégorie sélectionnée est invalide.',
            'montant.required' => 'Le montant du tarif est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.min' => 'Le montant doit être au moins 0.',
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.date' => 'La date de début doit être une date valide.',
            'date_fin.date' => 'La date de fin doit être une date valide.',
            'date_fin.after_or_equal' => 'La date de fin doit être après ou égale à la date de début.',
        ]);

        $tarif = Tarif::findOrFail($id);
        $tarif->update($request->all());

        return redirect()->route('admin.tarifs.index')
            ->with('success', 'Tarif mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tarif = Tarif::findOrFail($id);
        $tarif->delete();

        return redirect()->route('admin.tarifs.index')
            ->with('success', 'Tarif supprimé avec succès.');
    }
}
