<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

      protected $fillable = [
        'date_publication',
        'date_debut',
        'date_fin',
        'statut',
        'prix_journalier',
        'premium',
        'adresse',
        'objet_id',
        'proprietaire_id',
        'premium_periode',
        'premium_start_date',
    ];

    protected $casts = [
        'date_publication' => 'datetime',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'premium' => 'boolean',
        'premium_start_date' => 'datetime',
        'statut' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    // Relations
    public function objet()
    {
        return $this->belongsTo(Objet::class, 'objet_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
    public function proprietaire()
    {
    return $this->belongsTo(Utilisateur::class, 'proprietaire_id');
    }
 public function partenaire()
    {
        return $this->belongsTo(Utilisateur::class, 'partenaire_id')->withDefault([
            'nom' => 'Anonyme',
            'prenom' => ''
        ]);
    }

    public function notifications(){ return $this->hasMany(Notification::class); }
 public function scopeActive($query)
    {
        return $query->where('statut', 'active');
    }
    // Accessors pour garantir le format DateTime
    public function getDateDebutAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getDateFinAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getDatePublicationAttribute($value)
    {
        return Carbon::parse($value);
    }

    // Vérifie si une période est disponible
    public function isAvailable($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        // Vérifie que les dates sont dans la période de l'annonce
        if ($start < $this->date_debut || $end > $this->date_fin) {
            return false;
        }

        // Vérifie les conflits avec les réservations existantes
        return !$this->reservations()
            ->where('statut', '!=', 'refusée')
            ->where(function($query) use ($start, $end) {
                $query->whereBetween('date_debut', [$start, $end])
                      ->orWhereBetween('date_fin', [$start, $end])
                      ->orWhere(function($query) use ($start, $end) {
                          $query->where('date_debut', '<=', $start)
                                ->where('date_fin', '>=', $end);
                      });
            })
            ->exists();
    }

    // Récupère toutes les périodes réservées
    public function getReservedPeriods()
    {
        return $this->reservations()
            ->where('statut', '!=', 'refusée')
            ->get()
            ->map(function($reservation) {
                return [
                    'start' => Carbon::parse($reservation->date_debut)->format('Y-m-d'),
                    'end' => Carbon::parse($reservation->date_fin)->format('Y-m-d'),
                ];
            });
    }

}
