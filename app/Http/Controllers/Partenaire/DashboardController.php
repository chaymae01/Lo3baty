<?php

namespace App\Http\Controllers\Partenaire;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Objet;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $partnerId = auth()->id() ?? 1;

        // Réservations
        $annonceIds = Annonce::where('proprietaire_id', $partnerId)->pluck('id');

        $reservationsStats = Reservation::whereIn('annonce_id', $annonceIds)
            ->selectRaw("
                SUM(CASE WHEN statut = 'en_attente' THEN 1 ELSE 0 END) as en_attente,
                SUM(CASE WHEN statut = 'confirmée' THEN 1 ELSE 0 END) as valide,
                SUM(CASE WHEN statut = 'refusée' THEN 1 ELSE 0 END) as refuse
            ")
            ->first();

        // Annonces
        $annoncesStats = Annonce::where('proprietaire_id', $partnerId)
            ->selectRaw("
                SUM(CASE WHEN statut = 'active' THEN 1 ELSE 0 END) as actives,
                SUM(CASE WHEN statut != 'active' THEN 1 ELSE 0 END) as archivees
            ")
            ->first();

        // Produits
        $totalProduits = Objet::where('proprietaire_id', $partnerId)->count();

        return view('partenaire.dashboard', compact(
            'reservationsStats',
            'annoncesStats',
            'totalProduits'
        ));
    }
}
