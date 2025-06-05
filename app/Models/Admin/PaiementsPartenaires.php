<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateur;
use App\Models\Annonce;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaiementsPartenaires extends Model
{
    protected $table = 'paiements_partenaires';
    
    protected $fillable = [
        'annonce_id',
        'partenaire_id',
        'montant',
        'methode',
        'date_paiement',
        'periode'
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
        'montant' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public const PERIODES = [
        7 => '7 jours',
        15 => '15 jours', 
        30 => '30 jours'
    ];

    public function partenaire(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'partenaire_id')
            ->select(['id', 'nom', 'prenom', 'surnom', 'email']);
    }

    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class)
            ->select(['id', 'prix_journalier', 'date_debut', 'date_fin', 'statut', 'premium_periode']);
    }

    public function scopeFilter($query, array $filters)
    {
        return $query->when($filters['methode'] ?? false, fn($query, $methode) =>
                $query->where('methode', $methode)
            )
            ->when($filters['periode'] ?? false, fn($query, $periode) =>
                $query->where('periode', $periode)
            )
            ->when($filters['date_from'] ?? false, fn($query, $date) =>
                $query->whereDate('date_paiement', '>=', $date)
            )
            ->when($filters['date_to'] ?? false, fn($query, $date) =>
                $query->whereDate('date_paiement', '<=', $date)
            )
            ->when($filters['partenaire_id'] ?? false, fn($query, $id) =>
                $query->where('partenaire_id', $id)
            );
    }

    public function getPeriodeTextAttribute(): string
    {
        return self::PERIODES[$this->periode] ?? 'Non spécifiée';
    }

    public function getFormattedMontantAttribute(): string
    {
        return number_format($this->montant, 2, ',', ' ').' €';
    }

    public function isPremium(): bool
    {
        return $this->annonce && $this->annonce->premium_periode !== null;
    }
}