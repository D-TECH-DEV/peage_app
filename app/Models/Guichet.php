<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guichet extends Model
{
    protected $table = 'guichet';
    protected $fillable = ['code', 'statut'];

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'guichet_id');
    }
}
