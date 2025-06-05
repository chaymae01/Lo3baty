<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationOnClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'client_id',
        'partner_id',
        'note',
        'commentaire',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];  
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function client()
    {
        return $this->belongsTo(Utilisateur::class, 'client_id');
    }

    public function partner()
    {
        return $this->belongsTo(Utilisateur::class, 'partner_id');
    }
}