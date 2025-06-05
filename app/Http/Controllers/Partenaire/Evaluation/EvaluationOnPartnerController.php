<?php

namespace App\Http\Controllers\Partenaire\Evaluation;

use App\Http\Controllers\Controller;
use App\Models\EvaluationOnPartner;
use Illuminate\Http\Request;

class EvaluationOnPartnerController extends Controller
{

    public function commentaires()
    {
        $partnerId = auth()->id() ?? 1;

        $evaluations = EvaluationOnPartner::with('client')
            ->where('partner_id', $partnerId)
            ->whereNotNull('commentaire')
            ->latest()
            ->get();

        return view('partenaire.evaluations.commentaires', compact('evaluations'));
    }

    public function signaler(EvaluationOnPartner $evaluation)
    {
        $partnerId = auth()->id() ?? 1;

        if ($evaluation->partner_id != $partnerId) {
            abort(403);
        }

        $evaluation->update(['signaler' => true]);

        return back()->with('ok', 'Commentaire signalé avec succès.');
    }

    public function unsignaler(EvaluationOnPartner $evaluation)
    {
        $evaluation->update(['signaler' => false]);

        return back()->with('ok', 'Signalement retiré.');
    }


}