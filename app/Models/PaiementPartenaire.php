<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaiementPartenaire extends Model
{
    protected $table = 'paiements_partenaires';

    protected $fillable = [
        'annonce_id',
        'partenaire_id',
        'montant',
        'methode',
        'date_paiement',
        'periode',
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
        'periode' => 'string',
    ];

    public function partenaire()
    {
        return $this->belongsTo(Utilisateur::class, 'partenaire_id');
    }

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }
}
