<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorieVehicule extends Model
{
    protected $table = 'categorie_vehicule';
    protected $fillable = ['libelle'];

    public function tarifs()
    {
        return $this->hasMany(Tarif::class, 'categorie_vehicule_id');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'categorie_vehicule_id');
    }
}
