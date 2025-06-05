<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\EvaluationOnClients;
use App\Models\Admin\EvaluationOnPartners;
use App\Models\Admin\EvaluationOnAnnonces;

class Commentaire extends Model
{
    public static function getAllWithFilters($filters = [])
    {
        $queryClient = EvaluationOnClients::with(['client', 'partner', 'reservation'])
        ->orderBy('created_at', 'desc');
        
    $queryPartner = EvaluationOnPartners::with(['client', 'partner', 'reservation'])
        ->orderBy('created_at', 'desc');
        
    // CORRECTION : Utilisez le bon nom de relation 'objet' qui est défini dans EvaluationOnAnnonces
    $queryAnnonce = EvaluationOnAnnonces::with(['client', 'objet'])
        ->orderBy('created_at', 'desc');

        // Filtrage par statut
        if (isset($filters['statut'])) {
            $isFlagged = $filters['statut'] === 'signale';
            $queryClient->where('is_flagged', $isFlagged);
            $queryPartner->where('is_flagged', $isFlagged);
            $queryAnnonce->where('is_flagged', $isFlagged);
        }

        // Filtrage par type
        if (isset($filters['type'])) {
            switch ($filters['type']) {
                case 'client_partenaire':
                    return $queryClient->get();
                case 'partenaire_client':
                    return $queryPartner->get();
                case 'annonce':
                    return $queryAnnonce->get();
            }
        }

        return $queryClient->get()
            ->concat($queryPartner->get())
            ->concat($queryAnnonce->get())
            ->sortByDesc('created_at');
    }

    public static function findCommentaire($id)
    {
        $commentaire = EvaluationOnClients::find($id);
        
        if (!$commentaire) {
            $commentaire = EvaluationOnPartners::find($id);
        }
        
        if (!$commentaire) {
            $commentaire = EvaluationOnAnnonces::find($id);
        }

        return $commentaire;
    }
}