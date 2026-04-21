<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    


    public static function getCurrentTarifBynMontant($montant){
        return static::query()
            ->select()
            ->where("montant", $montant)
            ->where('date_fin', Null)
            ->get();
    }
}
