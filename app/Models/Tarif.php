<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $table = 'tarif';
    protected $fillable = [
        'categorie_vehicule_id',
        'montant',
        'date_debut',
        'date_fin'
    ];

    public function categorieVehicule()
    {
        return $this->belongsTo(CategorieVehicule::class, 'categorie_vehicule_id');
    }

    public static function getCurrentTarifByMontant($montant)
    {
        return static::query()
            ->where("montant", $montant)
            ->whereNull('date_fin')
            ->first();
    }
}
