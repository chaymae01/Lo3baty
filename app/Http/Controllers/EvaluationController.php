<?php

namespace App\Http\Controllers;

use App\Models\{Reservation, EvaluationOnAnnonce, EvaluationOnPartner};
use Illuminate\Http\Request;
namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\EvaluationOnAnnonce;
use App\Models\EvaluationOnPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
class EvaluationController extends Controller
{
    public function create(Reservation $reservation)
    {
    //      if (now()->lt($reservation->date_fin)) {
    //     abort(403, 'L’évaluation n’est disponible qu’après la fin de la réservation.');
    // }

    if (Auth::id() !== $reservation->client_id) {
            abort(403, "Cette réservation ne vous appartient pas.");
        }

    // if ($reservation->evaluation_date !== null) {
    //     abort(403, 'Vous avez déjà soumis une évaluation pour cette réservation.');
    // }
    
    if (Carbon::now()->lt($reservation->date_fin)) {
        return redirect()->back()->withErrors('Les évaluations ne sont disponibles qu\'après la fin de la location');
    }
    
    if ($reservation->evaluation_date) {
        return redirect()->back()->withErrors('Vous avez déjà évalué cette réservation');
    }
        return view('client.eval_Annonce', [
            'reservation' => $reservation,
            'annonce' => $reservation->annonce,
            'partner' => $reservation->annonce->proprietaire,
            'objet' => $reservation->annonce->objet
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'annonce_note' => 'required|integer|between:1,5',
            'annonce_comment' => 'required|string|max:500',
            'partner_note' => 'required|integer|between:1,5',
            'partner_comment' => 'required|string|max:500',
            'reservation_id' => 'required|exists:reservations,id',
            'objet_id' => 'required|exists:objets,id',
            'partner_id' => 'required|exists:utilisateurs,id',
            'client_id' => 'required|exists:utilisateurs,id'
        ]);

        EvaluationOnAnnonce::create([
            'reservation_id' => $validated['reservation_id'],
            'objet_id' => $validated['objet_id'],
            'client_id' => $validated['client_id'],
            'note' => $validated['annonce_note'],
            'commentaire' => $validated['annonce_comment']
        ]);

        EvaluationOnPartner::create([
            'reservation_id' => $validated['reservation_id'],
            'partner_id' => $validated['partner_id'],
            'client_id' => $validated['client_id'],
            'note' => $validated['partner_note'],
            'commentaire' => $validated['partner_comment']
        ]);

        $reservation = Reservation::findOrFail($validated['reservation_id']);
        $reservation->update([
            'evaluation_date' => now()
        ]);
          
        return response()->json([
        'message' => 'Merci pour vos évaluations !',
        'redirect' => route('annonces')    
    ]);
      
    }
}