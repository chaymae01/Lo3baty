<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);
        
        $client_id = auth()->id();
    
        // Vérification disponibilité
        $existingReservation = Reservation::where('annonce_id', $request->annonce_id)
            ->where(function($query) use ($request) {
                $query->whereBetween('date_debut', [$request->date_debut, $request->date_fin])
                      ->orWhereBetween('date_fin', [$request->date_debut, $request->date_fin])
                      ->orWhere(function($query) use ($request) {
                          $query->where('date_debut', '<=', $request->date_debut)
                                ->where('date_fin', '>=', $request->date_fin);
                      });
            })
            ->where('statut', '!=', 'confirmée')
            ->exists();
    
        if ($existingReservation) {
            return back()->with('error', 'Cette période est déjà réservée.');
        }
    
        // Stocker les données de réservation en session au lieu de créer la réservation
        $reservationData = [
            'client_id' => $client_id,
            'annonce_id' => $request->annonce_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'statut' => 'en_attente',
        ];
    
        session()->put('pending_reservation', $reservationData);
    
        // Rediriger vers la page de paiement
        return redirect()->route('paiement.show');
    }
}