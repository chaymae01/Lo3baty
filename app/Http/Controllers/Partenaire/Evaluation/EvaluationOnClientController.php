<?php

namespace App\Http\Controllers\Partenaire\Evaluation;

use App\Http\Controllers\Controller;
use App\Models\EvaluationOnClient;
use App\Models\Reservation;
use Illuminate\Http\Request;

class EvaluationOnClientController extends Controller
{
    public function index()
    {
        $partnerId = auth()->id() ?? 1;

        // ✅ Évaluations déjà faites par le partenaire
        $evaluations = EvaluationOnClient::with(['reservation', 'client'])
                        ->where('partner_id', $partnerId)
                        ->latest()
                        ->get();

        // 🔍 Réservations confirmées & terminées qui n’ont pas encore d’évaluation
        $reservations = Reservation::with(['client', 'annonce.objet'])
                        ->where('statut', 'confirmée')
                        ->whereHas('annonce', function ($q) use ($partnerId) {
                            $q->where('proprietaire_id', $partnerId);
                        })
                        ->whereDate('date_fin', '<=', now())
                        ->whereDoesntHave('evaluationOnClient')  // NE PAS afficher si déjà évalué
                        ->get();

        return view('partenaire.evaluations.index', compact('reservations', 'evaluations'));
    }


    public function create(Reservation $reservation)
    {
        // Vérifie si une évaluation existe déjà
        $existing = EvaluationOnClient::where('reservation_id', $reservation->id)->first();
        if ($existing) {
            return redirect()->route('partenaire.evaluations.index')
                ->with('error', 'Vous avez déjà évalué ce client pour cette réservation.');
        }

        return view('partenaire.evaluations.create', compact('reservation'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
        ]);

        $reservation = Reservation::findOrFail($data['reservation_id']);

        EvaluationOnClient::create([
            'reservation_id' => $reservation->id,
            'client_id' => $reservation->client_id,
            'partner_id' => auth()->id() ?? 1,
            'note' => $data['note'],
            'commentaire' => $data['commentaire'],
        ]);

        return redirect()->route('partenaire.evaluations.index')
            ->with('ok', 'Évaluation ajoutée avec succès 🎉');
    }
}
