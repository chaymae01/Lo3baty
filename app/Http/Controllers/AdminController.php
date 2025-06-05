<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Admin\EvaluationOnAnnonces; // Utilisation du bon modèle
use App\Models\Utilisateur;
use App\Models\Notification;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use App\Models\Reclamation;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistiques de base
        $partnerCount = Utilisateur::where('role', 'partenaire')->count();
        $clientCount = Utilisateur::where('role', 'client')->count();
        $annonceCount = Annonce::count();
         $nouveauxReclamations = Reclamation::whereIn('statut', ['en_attente', 'en_cours'])->count();
        
        
        // Calcul du revenu total
     $totalRevenue = DB::table('reservations')
        ->join('annonces', 'reservations.annonce_id', '=', 'annonces.id')
        ->join('paiements_clients', 'reservations.id', '=', 'paiements_clients.reservation_id')
        ->where('paiements_clients.etat', 'effectué')
        ->sum(DB::raw('ROUND(paiements_clients.montant * 0.15, 2)'));

    // Revenu par logement
  $revenusParLogement = DB::table('reservations')
    ->join('annonces', 'reservations.annonce_id', '=', 'annonces.id')
    ->join('objets', 'annonces.objet_id', '=', 'objets.id')
    ->join('paiements_clients', 'reservations.id', '=', 'paiements_clients.reservation_id')
    ->where('paiements_clients.etat', 'effectué')
    ->select('objets.Ville', DB::raw('ROUND(SUM(paiements_clients.montant * 0.15), 2) as total'))
    ->groupBy('objets.Ville')
    ->get();


$reservations = Reservation::with(['annonce.objet', 'client'])
    ->where('date_fin', '>=', now())
    ->get()
    ->map(function ($reservation) {
        return [
            'title' => $reservation->annonce->objet->nom,
            'start' => $reservation->date_debut,
            'end' => $reservation->date_fin->addDay(), // pour inclure la date de fin
            'property_name' => $reservation->annonce->objet->nom,
            'client_name' => $reservation->client->nom . ' ' . $reservation->client->prenom,
            'status' => $reservation->statut,
            'amount' => $reservation->montant,
            'color' => $reservation->statut === 'confirmée' ? '#10b981' : 
                      ($reservation->statut === 'refusée' ? '#ef4444' : '#f59e0b')
        ];
    });
     $reclamations = Reclamation::with('utilisateur') // Charger l'utilisateur associé à la réclamation
            ->orderBy('statut', 'desc') // Trier les réclamations par date
            ->take(5) // Limiter à 5 réclamations récentes
            ->get();

    $revenusParPeriode = DB::table('paiements_partenaires')
    ->select('periode', DB::raw('SUM(montant) as total'))
    ->groupBy('periode')
    ->orderByRaw('CAST(periode AS UNSIGNED)')
    ->get();




        // Dernières annonces
        $latestAnnonces = Annonce::with(['partenaire', 'objet'])
                              ->latest()
                              ->take(5)
                              ->get();

        // Nouveaux partenaires
        $newPartners = Utilisateur::where('role', 'partenaire')
                               ->latest()
                               ->take(5)
                               ->get();

        // Notifications
        $messages = Notification::with('utilisateur')
                            ->latest()
                            ->take(5)
                            ->get();

        // Évaluations - Utilisation du bon modèle EvaluationOnAnnonces
        $evaluations = EvaluationOnAnnonces::with(['objet', 'client'])
                              ->latest()
                              ->take(5)
                              ->get();

        return view('admin.dashboard', compact(
            'partnerCount', 
            'clientCount', 
            'annonceCount', 
            'totalRevenue', 
            'latestAnnonces', 
            'newPartners', 
            'messages',
            'evaluations',
            'revenusParPeriode',
             'revenusParLogement',
             'reservations',
             'reclamations',
             'nouveauxReclamations'
        ));
   
   
    }

}