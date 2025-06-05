<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\EvaluationOnAnnonce;
use App\Models\EvaluationOnPartner;
use App\Models\Objet;

use Carbon\Carbon;

class AnnonceDetailsController extends Controller
{
    public function show($id)
    {
        $annonce = Annonce::with(['objet.images', 'proprietaire', 'reservations.client'])
                          ->findOrFail($id);

        $evaluationsObjet = EvaluationOnAnnonce::with(['client'])
            ->where('objet_id', $annonce->objet_id)
            ->get();

        $evaluationsPartner = EvaluationOnPartner::with(['client'])
            ->where('partner_id', $annonce->proprietaire_id)
            ->get();

        $reservedPeriods = $annonce->getReservedPeriods();
 
        $relatedProduits = Objet::with(['annonces', 'images'])
        ->where('categorie_id', $annonce->objet->categorie_id)
        ->where('id', '!=', $annonce->objet->id)
        ->take(4)
        ->get();

        return view('client.details_annonce', compact(
            'annonce',
            'evaluationsObjet',
            'evaluationsPartner',
            'reservedPeriods',
            'relatedProduits'
        ));
    }
}