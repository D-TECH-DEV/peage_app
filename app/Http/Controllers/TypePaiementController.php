<?php

namespace App\Http\Controllers;

use App\Models\TypePaiement;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class TypePaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "libelle" => 'required|int'
        ],[
            "libelle.required" => "Le libelle est oligatoire pour l'ajout d'un tarif",
            "libelle.int" => "Le libelle doit être un entier"
        ]);

        //$currentTarif=Tarif::getCurrentTarifBynlibelle($request->libelle);

        // if($currentTarif.isNull()) {
        //     return back()->withErrors("Le libelle est actuellement disponible") ;
        // }

        $tarif = TypePaiement::create([
            "libelle" => $request->libelle
        ]);

        return redirect("tarif.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "libelle" => 'required|string'
        ],[
            "libelle.required" => "Le libelle est oligatoire pour l'ajout d'un type de paiement",
            "libelle.sting" => "Le libelle doit être un un chaine de caractère"
        ]);


        $tarif = TypePaiement::where('id', $id)->update([
            "libelle" => $request->libelle
        ]);

        return redirect("Le type de paiement a bien été mis à jour !");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
