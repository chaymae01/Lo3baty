<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationOnAnnonce extends Model
{
    use HasFactory;


    protected $fillable = [
        'objet_id',
        'client_id',
        'note',
        'commentaire'
    ];

    public function objet()
    {
        return $this->belongsTo(Objet::class);
    }

    public function client()
    {
        return $this->belongsTo(Utilisateur::class, 'client_id');
    }
}