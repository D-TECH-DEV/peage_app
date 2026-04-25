<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\CategorieVehicule;
use App\Models\Tarif;
use App\Models\TypePaiement;
use App\Models\Guichet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'immatriculation' => 'nullable|string|max:50',
            'categorie_vehicule_id' => 'required|exists:categorie_vehicule,id',
            'type_paiement_id' => 'required|exists:type_paiement,id',
        ], [
            'categorie_vehicule_id.required' => 'La catégorie de véhicule est obligatoire.',
            'categorie_vehicule_id.exists' => 'La catégorie sélectionnée est invalide.',
            'type_paiement_id.required' => 'Le type de paiement est obligatoire.',
            'type_paiement_id.exists' => 'Le type de paiement sélectionné est invalide.',
        ]);

        
        $tarif = Tarif::where('categorie_vehicule_id', $request->categorie_vehicule_id)
            ->where(function ($query) {
                $query->whereNull('date_fin')
                      ->orWhere('date_fin', '>=', now());
            })->first();
        
        $montant = $tarif ? $tarif->montant : 0;

        
        $user_id = Auth::id() ?? (User::first()->id ?? null);
        
        $guichet_id = session('guichet_id');

        $paiement = Paiement::create([
            'date_paiement' => now(),
            'immatriculation' => $request->immatriculation,
            'categorie_vehicule_id' => $request->categorie_vehicule_id,
            'type_paiement_id' => $request->type_paiement_id,
            'montant' => $montant,
            'user_id' => $user_id,
            'guichet_id' => $guichet_id,
            'statut' => 'Payé',
        ]);

        $redirect = redirect()->route('admin.paiements.index')->with('success', 'Paiement enregistré avec succès.');
        if ($request->has('auto_print')) {
            $redirect->with('print_receipt_id', $paiement->id);
        }

        return $redirect;
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

    public function receipt(string $id)
    {
        $paiement = Paiement::with(['categorieVehicule', 'typePaiement', 'guichet', 'user'])->findOrFail($id);
        return view('admin.paiements.receipt_print', compact('paiement'));
    }

    public function exportCsv()
    {
        $paiements = Paiement::with(['categorieVehicule', 'typePaiement', 'guichet', 'user'])->get();

        $filename = "transactions_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Headers
        fputcsv($handle, ['ID', 'Date', 'Categorie', 'Immatriculation', 'Guichet', 'Mode de Paiement', 'Montant', 'Statut', 'Agent']);

        // Data
        foreach ($paiements as $p) {
            fputcsv($handle, [
                $p->id,
                $p->date_paiement ?? $p->created_at,
                $p->categorieVehicule->libelle ?? 'N/A',
                $p->immatriculation ?? '-',
                $p->guichet->code ?? 'N/A',
                $p->typePaiement->libelle ?? 'N/A',
                $p->montant,
                $p->statut ?? 'Payé',
                $p->user->nom ?? 'N/A'
            ]);
        }

        fclose($handle);
        exit;
    }
}
