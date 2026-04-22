<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePaiement extends Model
{
    protected $table = 'type_paiement';
    protected $fillable = ['libelle'];

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'type_paiement_id');
    }
}
