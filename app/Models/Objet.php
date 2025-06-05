<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objet extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_ajout',
        'nom',
        'tranche_age',
        'description',
        'ville',
        'prix_journalier',
        'etat',
        'categorie_id',
        'proprietaire_id'
    ];

    protected $casts = [
        'etat' => 'string'
    ];
    protected $dates = ['date_ajout'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function proprietaire()
    {
        return $this->belongsTo(Utilisateur::class, 'proprietaire_id');
    }

      public function evaluations()
    {
        return $this->hasMany(EvaluationOnAnnonce::class);
    }

    public function getNoteMoyenneAttribute()
    {
        return round($this->evaluations()->avg('note'), 1) ?? null;
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }
}