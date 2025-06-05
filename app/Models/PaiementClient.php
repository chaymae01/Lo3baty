<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaiementClient extends Model
{
    protected $table = 'paiements_clients';

    protected $fillable = [
        'reservation_id',
        'client_id',
        'montant',
        'methode',
        'date_paiement',
        'etat',
        'livraison',
        'montant_livraison',
    ];
    

    protected $casts = [
        'date_paiement' => 'datetime',
        'etat' => 'string',
    ];

    public function client()
    {
        return $this->belongsTo(Utilisateur::class, 'client_id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
