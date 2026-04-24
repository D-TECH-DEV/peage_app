<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\CategorieVehicule;
use App\Models\TypePaiement;
use App\Models\Guichet;
use App\Models\User;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paiements = Paiement::with(['categorieVehicule', 'typePaiement', 'guichet', 'user'])->get();
        $categories = CategorieVehicule::all();
        $types = TypePaiement::all();
        $guichets = Guichet::all();
        $users = User::all();
        return view('admin.paiements.index', compact('paiements', 'categories', 'types', 'guichets', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategorieVehicule::all();
        $types = TypePaiement::all();
        $guichets = Guichet::all();
        $users = User::all();
        return view('admin.paiements.create', compact('categories', 'types', 'guichets', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date_paiement' => 'nullable|date',
            'montant' => 'required|numeric|min:0',
            'immatriculation' => 'nullable|string|max:50',
            'categorie_vehicule_id' => 'required|exists:categorie_vehicule,id',
            'type_paiement_id' => 'required|exists:type_paiement,id',
            'guichet_id' => 'required|exists:guichet,id',
            'user_id' => 'required|exists:user,id',
            'statut' => 'nullable|string|max:50',
        ], [
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.min' => 'Le montant doit être au moins 0.',
            'categorie_vehicule_id.required' => 'La catégorie de véhicule est obligatoire.',
            'categorie_vehicule_id.exists' => 'La catégorie sélectionnée est invalide.',
            'type_paiement_id.required' => 'Le type de paiement est obligatoire.',
            'type_paiement_id.exists' => 'Le type de paiement sélectionné est invalide.',
            'guichet_id.required' => 'Le guichet est obligatoire.',
            'guichet_id.exists' => 'Le guichet sélectionné est invalide.',
            'user_id.required' => 'L’utilisateur est obligatoire.',
            'user_id.exists' => 'L’utilisateur sélectionné est invalide.',
            'date_paiement.date' => 'La date de paiement doit être une date valide.',
        ]);

        Paiement::create($request->all());

        return redirect()->route('admin.paiements.index')
            ->with('success', 'Paiement enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paiement = Paiement::with(['categorieVehicule', 'typePaiement', 'guichet', 'user'])->findOrFail($id);
        return view('admin.paiements.show', compact('paiement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paiement = Paiement::findOrFail($id);
        $categories = CategorieVehicule::all();
        $types = TypePaiement::all();
        $guichets = Guichet::all();
        $users = User::all();
        return view('admin.paiements.edit', compact('paiement', 'categories', 'types', 'guichets', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'date_paiement' => 'nullable|date',
            'montant' => 'required|numeric|min:0',
            'immatriculation' => 'nullable|string|max:50',
            'categorie_vehicule_id' => 'required|exists:categorie_vehicule,id',
            'type_paiement_id' => 'required|exists:type_paiement,id',
            'guichet_id' => 'required|exists:guichet,id',
            'user_id' => 'required|exists:user,id',
            'statut' => 'nullable|string|max:50',
        ], [
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.min' => 'Le montant doit être au moins 0.',
            'categorie_vehicule_id.required' => 'La catégorie de véhicule est obligatoire.',
            'categorie_vehicule_id.exists' => 'La catégorie sélectionnée est invalide.',
            'type_paiement_id.required' => 'Le type de paiement est obligatoire.',
            'type_paiement_id.exists' => 'Le type de paiement sélectionné est invalide.',
            'guichet_id.required' => 'Le guichet est obligatoire.',
            'guichet_id.exists' => 'Le guichet sélectionné est invalide.',
            'user_id.required' => 'L’utilisateur est obligatoire.',
            'user_id.exists' => 'L’utilisateur sélectionné est invalide.',
            'date_paiement.date' => 'La date de paiement doit être une date valide.',
        ]);

        $paiement = Paiement::findOrFail($id);
        $paiement->update($request->all());

        return redirect()->route('admin.paiements.index')
            ->with('success', 'Paiement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->delete();

        return redirect()->route('admin.paiements.index')
            ->with('success', 'Paiement supprimé avec succès.');
    }
}
