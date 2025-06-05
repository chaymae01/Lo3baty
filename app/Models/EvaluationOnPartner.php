<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationOnPartner extends Model
{
    use HasFactory;

    protected $table = 'evaluation_on_partners';

    protected $fillable = [
        'reservation_id',
        'partner_id',
        'client_id',
        'note',
        'commentaire',
        'signaler',
    ];

        protected $casts = [
        'signaler' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function partner()
    {
        return $this->belongsTo(Utilisateur::class, 'partner_id');
    }

    public function client()
    {
        return $this->belongsTo(Utilisateur::class, 'client_id');
    }
}