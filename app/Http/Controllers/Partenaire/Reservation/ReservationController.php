<?php
namespace App\Http\Controllers\Partenaire\Reservation;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Reservation;
use App\Models\PaiementClient;


class ReservationController extends Controller
{
    public function index()
    {
        $proprietaireId = auth()->id() ?? 1;
    
        $annonceIds = Annonce::where('proprietaire_id', $proprietaireId)->pluck('id');
    
        // Refuser celles > 24h
        Reservation::whereIn('annonce_id', $annonceIds)
            ->where('statut', 'en_attente')
            ->where('created_at', '<', now()->subHours(24))
            ->each(function ($res) {
                $res->update(['statut' => 'refusée']);

                PaiementClient::where('reservation_id', $res->id)
                    ->update(['etat' => 'annulé']);
            });
    
        $reservations = Reservation::with(['annonce', 'client'])
            ->whereIn('annonce_id', $annonceIds)
            ->where('statut', 'en_attente')
            ->get();
    
        return view('partenaire.reservations.index', compact('reservations'));
    }
    

    public function valider(Reservation $reservation)
    {
        $reservation->update(['statut' => 'confirmée']);

        PaiementClient::where('reservation_id', $reservation->id)
        ->update(['etat' => 'effectué']);

        return back()->with('ok', 'Réservation validée ✅');
    }

    public function refuser(Reservation $reservation)
    {
        $reservation->update(['statut' => 'refusée']);

        PaiementClient::where('reservation_id', $reservation->id)
        ->update(['etat' => 'annulé']);

        return back()->with('ok', 'Réservation refusée ❌');
    }
}
