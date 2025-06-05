<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = [
        'note',
        'commentaire',
        'objet_id',
        'evaluateur_id',
        'evalue_id'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function objet()
    {
        return $this->belongsTo(Objet::class);
    }

    public function evaluateur()
    {
        return $this->belongsTo(Utilisateur::class, 'evaluateur_id');
    }

    public function evalue()
    {
        return $this->belongsTo(Utilisateur::class, 'evalue_id');
    }
}