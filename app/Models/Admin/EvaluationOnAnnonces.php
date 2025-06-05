<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateur;
use App\Models\Objet;

class EvaluationOnAnnonces extends Model
{
    protected $table = 'evaluation_on_annonces';

    protected $fillable = [
        'objet_id',
        'client_id',
        'note',
        'commentaire',
        'is_flagged',
        'flag_reason'
    ];

    protected $casts = [
        'is_flagged' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function client()
    {
        return $this->belongsTo(Utilisateur::class, 'client_id');
    }

    public function objet()
    {
        return $this->belongsTo(Objet::class);
    }

    public function getTypeAttribute()
    {
        return 'Évaluation d\'annonce';
    }
}