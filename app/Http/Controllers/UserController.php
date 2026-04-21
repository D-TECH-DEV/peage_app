<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class UserController extends Controller
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
            "montant" => 'required|int'
        ],[
            "montant.required" => "Le montant est oligatoire pour l'ajout d'un tarif",
            "montant.int" => "Le montant doit être un entier"
        ]);

        $currentTarif=Tarif::getCurrentTarifBynMontant($request->montant);

        if($currentTarif.isNull()) {
            return back()->withErrors("Le montant est actuellement disponible") ;
        }

        $tarif = Tarif::update([
            "montant" => $request->montant
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
            "montant" => 'required|int|'
        ],[
            "montant.required" => "Le montant est oligatoire pour l'ajout d'un tarif",
            "montant.int" => "Le montant doit être un entier"
        ]);

       $currentTarif=Tarif::getCurrentTarifBynMontant($request->montant);

       if($currentTarif.isNull()) {
            return back()->withErrors("Le montant est actuellement disponible") ;
       }

        $tarif = Tarif::update([
            "montant" => $request->montant
        ]);

        return redirect("Le montant a bien été mis à jour !");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
