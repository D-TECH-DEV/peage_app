<?php

namespace App\Http\Controllers;

use App\Models\CategorieVehicule;
use Illuminate\Http\Request;

class CategorieVehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategorieVehicule::all();
        // Assuming view exists
        return view('admin.categories-vehicules.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories-vehicules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:100',
        ], [
            'libelle.required' => 'Le libellé de la catégorie est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne doit pas dépasser 100 caractères.',
        ]);

        CategorieVehicule::create($request->all());

        return redirect()->route('admin.categories-vehicules.index')
            ->with('success', 'Catégorie de véhicule créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categorie = CategorieVehicule::findOrFail($id);
        return view('admin.categories-vehicules.show', compact('categorie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categorie = CategorieVehicule::findOrFail($id);
        return view('admin.categories-vehicules.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'libelle' => 'required|string|max:100',
        ], [
            'libelle.required' => 'Le libellé de la catégorie est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne doit pas dépasser 100 caractères.',
        ]);

        $categorie = CategorieVehicule::findOrFail($id);
        $categorie->update($request->all());

        return redirect()->route('admin.categories-vehicules.index')
            ->with('success', 'Catégorie de véhicule mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categorie = CategorieVehicule::findOrFail($id);
        $categorie->delete();

        return redirect()->route('admin.categories-vehicules.index')
            ->with('success', 'Catégorie de véhicule supprimée avec succès.');
    }
}
