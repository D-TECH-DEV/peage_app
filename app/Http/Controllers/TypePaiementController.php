<?php

namespace App\Http\Controllers;

use App\Models\TypePaiement;
use Illuminate\Http\Request;

class TypePaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = TypePaiement::all();
        return view('admin.types-paiements.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.types-paiements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:50',
        ], [
            'libelle.required' => 'Le libellé du type de paiement est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne doit pas dépasser 50 caractères.',
        ]);

        TypePaiement::create($request->all());

        return redirect()->route('admin.types-paiements.index')
            ->with('success', 'Type de paiement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $type = TypePaiement::findOrFail($id);
        return view('admin.types-paiements.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $type = TypePaiement::findOrFail($id);
        return view('admin.types-paiements.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'libelle' => 'required|string|max:50',
        ], [
            'libelle.required' => 'Le libellé du type de paiement est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'libelle.max' => 'Le libellé ne doit pas dépasser 50 caractères.',
        ]);

        $type = TypePaiement::findOrFail($id);
        $type->update($request->all());

        return redirect()->route('admin.types-paiements.index')
            ->with('success', 'Type de paiement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = TypePaiement::findOrFail($id);
        $type->delete();

        return redirect()->route('admin.types-paiements.index')
            ->with('success', 'Type de paiement supprimé avec succès.');
    }
}
