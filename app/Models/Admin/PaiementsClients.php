<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateur;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaiementsClients extends Model
{
    protected $table = 'paiements_clients';
    
    protected $fillable = [
        'reservation_id',
        'client_id',
        'montant',
        'methode',
        'date_paiement',
        'etat'
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
        'montant' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'client_id')
            ->select(['id', 'nom', 'prenom', 'surnom', 'email', 'image_profil']);
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class)
            ->select(['id', 'date_debut', 'date_fin', 'statut']);
    }

    public function scopeFilter($query, array $filters)
    {
        return $query->when($filters['methode'] ?? false, fn($query, $methode) => 
                $query->where('methode', $methode)
            )
            ->when($filters['etat'] ?? false, fn($query, $etat) =>
                $query->where('etat', $etat)
            )
            ->when($filters['date_from'] ?? false, fn($query, $date) =>
                $query->whereDate('date_paiement', '>=', $date)
            )
            ->when($filters['date_to'] ?? false, fn($query, $date) =>
                $query->whereDate('date_paiement', '<=', $date)
            )
            ->when($filters['client_id'] ?? false, fn($query, $id) =>
                $query->where('client_id', $id)
            )
            ->when(isset($filters['date_debut']) && $filters['date_debut'], function($query) use ($filters) {
                $query->whereHas('reservation', function($q) use ($filters) {
                    $q->whereDate('date_debut', '>=', $filters['date_debut']);
                });
            })
            ->when(isset($filters['date_fin']) && $filters['date_fin'], function($query) use ($filters) {
                $query->whereHas('reservation', function($q) use ($filters) {
                    $q->whereDate('date_fin', '<=', $filters['date_fin']);
                });
            });
    }

    public function getDureeLocationAttribute(): ?int
    {
        return optional($this->reservation)->date_debut
            ? $this->reservation->date_debut->diffInDays($this->reservation->date_fin)
            : null;
    }

    public function getFormattedMontantAttribute(): string
    {
        return number_format($this->montant, 2, ',', ' ').' €';
    }
}