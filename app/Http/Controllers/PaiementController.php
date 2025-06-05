<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaiementClient;
use App\Models\Annonce;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        $reservationData = session()->get('pending_reservation');
        
        if (!$reservationData) {
            return redirect()->back()->with('error', 'Aucune réservation en attente.');
        }

        if ($reservationData['client_id'] != $user->id) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        $reservation = new Reservation($reservationData);
        
        $annonce = Annonce::findOrFail($reservationData['annonce_id']);
        $reservation->setRelation('annonce', $annonce);

        return view('client.paiement', compact('reservation'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'methode' => 'required|in:paypal,especes,carte',
            'livraison' => 'required|boolean',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        $reservationData = session()->get('pending_reservation');
        
        if (!$reservationData) {
            return redirect()->back()->with('error', 'Aucune réservation en attente.');
        }

        if ($reservationData['client_id'] != $user->id) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        try {
           
            $reservation = Reservation::create($reservationData);
           
            $days = $reservation->date_debut->diffInDays($reservation->date_fin) + 1;
            $baseAmount = $reservation->annonce->prix_journalier * $days;
            $deliveryAmount = $request->livraison ? 20 : 0; 
            $totalAmount = $baseAmount + $deliveryAmount;

            $paiement = PaiementClient::create([
                'reservation_id' => $reservation->id,
                'client_id' => $reservationData['client_id'],
                'montant' => $totalAmount,
                'methode' => $request->methode,
                'date_paiement' => now(),
                'etat' => 'en_attente', 
                'livraison' => $request->livraison,
                'montant_livraison' => $deliveryAmount,
            ]);

            // Nettoyer la session
            session()->forget('pending_reservation');

            return redirect()->route('annonces')->with('success', 'Votre réservation est en cours de taitement durant!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors du traitement de votre paiement ou réservation.')
                ->withInput();
        }
    }
}