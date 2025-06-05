<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'annonce_id',
        'date_debut',
        'date_fin',
        'is_email',
        'statut',
        'evaluation_date',
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
        'date_creation' => 'datetime',
        'statut' => 'string',
        'evaluation_date'=> 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
        
    ];

    // Relations
    public function client()
    {
        return $this->belongsTo(Utilisateur::class, 'client_id');
    }

    public function annonce()
    {
        return $this->belongsTo(Annonce::class, 'annonce_id');
    }
    
    public function evaluationOnPartner()
    {
        return $this->hasOne(EvaluationOnPartner::class, 'reservation_id');
    }
      public function evaluationOnClient()
    {
        return $this->hasOne(EvaluationOnClient::class, 'reservation_id');
    }

    public function objet()
{
    return $this->hasOneThrough(Objet::class, Annonce::class, 'id', 'id', 'annonce_id', 'objet_id');
}


    public function getStatutCouleurAttribute()
    {
        return match(strtolower($this->statut)) {
            'confirmée' => 'bg-green-100 text-green-800',
            'en_attente' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-red-100 text-red-800'
        };
    }

}