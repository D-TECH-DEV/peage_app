<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $table = 'paiement';
    protected $fillable = [
        'date_paiement',
        'montant',
        'immatriculation',
        'categorie_vehicule_id',
        'type_paiement_id',
        'guichet_id',
        'user_id',
        'statut'
    ];

    public function categorieVehicule()
    {
        return $this->belongsTo(CategorieVehicule::class, 'categorie_vehicule_id');
    }

    public function typePaiement()
    {
        return $this->belongsTo(TypePaiement::class, 'type_paiement_id');
    }

    public function guichet()
    {
        return $this->belongsTo(Guichet::class, 'guichet_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
