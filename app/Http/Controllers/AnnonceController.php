<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objet;
use App\Models\Annonce;

class AnnonceController extends Controller
{

   public function index(Request $request)
{
    $query = Annonce::with(['objet.images', 'objet.categorie', 'proprietaire']) ->where('statut', 'active');
    $villes = Objet::select('ville')->distinct()->pluck('ville');

    if ($age = $request->input('age')) {
        $query->whereHas('objet', function ($q) use ($age) {
            $q->where('tranche_age', $age);
        });
    }

    $query->orderBy('premium', 'desc');

    if ($price = $request->input('price')) {
        $query->whereHas('objet', function ($q) use ($price) {
            switch ($price) {
                case '0-50':
                    $q->where('prix_journalier', '<', 50);
                    break;
                case '50-100':
                    $q->whereBetween('prix_journalier', [50, 100]);
                    break;
                case '100-150':
                    $q->whereBetween('prix_journalier', [100, 150]);
                    break;
                case '150+':
                    $q->where('prix_journalier', '>', 150);
                    break;
            }
        });
    }

    if ($type = $request->input('type')) {
        $query->whereHas('objet.categorie', function ($q) use ($type) {
            $q->where('nom', $type);
        });
    }

    if ($ville = $request->input('ville')) {
    $query->whereHas('objet', function ($q) use ($ville) {
        $q->where('ville', $ville);
    });
}

    if ($search = $request->input('search')) {
        $query->whereHas('objet', function ($q) use ($search) {
            $q->where('nom', 'like', '%' . $search . '%');
        });
    }

    if ($sort = $request->input('sort')) {
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('annonces.prix_journalier', 'asc'); // Sort by prix_journalier from annonces
                break;
            case 'price_desc':
                $query->orderBy('annonces.prix_journalier', 'desc'); // Sort by prix_journalier from annonces
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    $annonces = $query->paginate(6);

    $annonces->transform(function ($annonce) {
        // Fetch prix_journalier from the annonce instead of the objet
        $annonce->prix = number_format($annonce->prix_journalier, 2);
        
        // Ensure that image URL is still fetched from the objet's images relationship
        $objet = $annonce->objet;
        $annonce->image_url = $objet->images->first()->url ?? 'https://via.placeholder.com/288x320';
        
        return $annonce;
    });

    return view('client.annonces', compact('annonces', 'villes'));
}

    
}
