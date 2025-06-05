<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PaiementsClients;
use App\Models\Admin\PaiementsPartenaires;
use Illuminate\Http\Request;
use App\Exports\PaiementsClientsExport;
use App\Exports\PaiementsPartenairesExport;
use Maatwebsite\Excel\Facades\Excel;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        // Initialisation des requêtes avec les relations
        $queryClients = PaiementsClients::with([
            'client:id,surnom,email',
            'reservation:id,date_debut,date_fin'
        ]);
        
        $queryPartners = PaiementsPartenaires::with([
            'partenaire:id,surnom,email', 
            'annonce:id,prix_journalier,premium_periode'
        ]);

        // Filtre par type (clients/partenaires)
        $type = $request->input('type');
        if ($type === 'clients') {
            $queryPartners = null;
        } elseif ($type === 'partenaires') {
            $queryClients = null;
        }

        // Application des filtres avec les scopes
        if ($queryClients) {
    $queryClients->filter([
        'methode' => $request->methode,
        'etat' => $request->etat,
        'date_from' => $request->date_from,
        'date_to' => $request->date_to,
        'client_id' => $request->client_id,
        'date_debut' => $request->date_debut, // Ajouté pour le filtrage des réservations
        'date_fin' => $request->date_fin      // Ajouté pour le filtrage des réservations
    ]);
}

        if ($queryPartners) {
            $queryPartners->filter([
                'methode' => $request->methode,
                'periode' => $request->periode_premium,
                'date_from' => $request->date_debut,
                'date_to' => $request->date_fin,
                'partenaire_id' => $request->partenaire_id
            ]);
        }

        // Pagination avec gestion des collections vides
        $paiementsClients = $queryClients 
            ? $queryClients->latest()->paginate(10, ['*'], 'clients_page')
            : collect();

        $paiementsPartenaires = $queryPartners 
            ? $queryPartners->latest()->paginate(10, ['*'], 'partenaires_page')
            : collect();

        // Calcul des statistiques
        $statsQueryClients = $queryClients ? clone $queryClients : PaiementsClients::query();
        $statsQueryPartners = $queryPartners ? clone $queryPartners : PaiementsPartenaires::query();

        // Application des mêmes filtres aux statistiques
        if (!$queryClients) {
            $statsQueryClients->filter([
                'methode' => $request->methode,
                'date_from' => $request->date_debut,
                'date_to' => $request->date_fin
            ]);
        }

        if (!$queryPartners) {
            $statsQueryPartners->filter([
                'methode' => $request->methode,
                'periode' => $request->periode_premium,
                'date_from' => $request->date_debut,
                'date_to' => $request->date_fin
            ]);
        }

        $stats = [
          
    'total_clients' => $statsQueryClients->where('etat', 'effectué')->sum('montant'),

            'total_partenaires' => $statsQueryPartners->sum('montant'),
            'count_clients' => $statsQueryClients->count(),
            'count_partenaires' => $statsQueryPartners->count(),
        ];

        // Derniers paiements
        $lastClient = $statsQueryClients->orderByDesc('date_paiement')->first();
        $lastPartner = $statsQueryPartners->orderByDesc('date_paiement')->first();

        return view('admin.paiements.index', compact(
            'paiementsClients',
            'paiementsPartenaires',
            'stats',
            'lastClient',
            'lastPartner'
        ));
    }
    public function export(Request $request)
    {
        $type = $request->input('type', 'clients');
        $filters = $request->all();

        $fileName = 'paiements_' . $type . '_' . now()->format('Y-m-d') . '.xlsx';

        if ($type === 'clients') {
            return Excel::download(new PaiementsClientsExport($filters), $fileName);
        } else {
            return Excel::download(new PaiementsPartenairesExport($filters), $fileName);
        }
    }
}