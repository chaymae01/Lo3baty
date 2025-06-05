<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;


class ReservationHistoriqueController extends Controller
{
    public function reservations()
    {
        //$clientId = 1; // Replace with auth()->id() later
        $clientId = auth()->id();
        $statuses = ['En attente', 'Acceptée', 'Refusée'];
    
        $reservations = Reservation::with([
            'annonce.proprietaire.evaluationsPartenaire',
            'annonce.objet.images',
            'evaluationOnPartner'
        ])
        ->where('client_id', $clientId)
        ->get();
    
        return view('client.reservations', [
            'reservations' => $reservations,
            'counts' => $this->calculateStatusCounts($clientId, $statuses)
        ]);
    }
    
    private function calculateStatusCounts($clientId, $statuses)
    {
        return Reservation::where('client_id', $clientId)
            ->selectRaw('statut, count(*) as count')
            ->groupBy('statut')
            ->get()
            ->keyBy('statut')
            ->map(fn($item) => $item->count);
    }
}
