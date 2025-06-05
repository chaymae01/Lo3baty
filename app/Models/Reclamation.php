<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
   protected $table = 'reclamations';
        protected $fillable = [
        'utilisateur_id', 
        'sujet',
        'contenu',
        'statut',
        'reponse',
        'piece_jointe',
        'date_reponse'
    ];
    protected $casts = [
        'date_reponse' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
 
    protected $attributes = [
        'statut' => 'en_attente',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function utilisateur()  // Nom changé pour correspondre à la convention
    {
        return $this->belongsTo(Utilisateur::class)->withDefault([
            'name' => 'Utilisateur (ID: '.$this->utilisateur_id.') non trouvé'
        ]);
    }

    /**
     * Accessor pour le statut
     */
    public function getStatutAttribute($value)
    {
        return ucfirst(str_replace('_', ' ', $value));
    }

    /**
     * Mutator pour le statut
     */
    public function setStatutAttribute($value)
    {
        $this->attributes['statut'] = strtolower(str_replace(' ', '_', $value));
    }
    // Gestion des timestamps
    public $timestamps = true;
}