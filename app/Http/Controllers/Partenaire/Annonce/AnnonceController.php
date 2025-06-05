<?php

namespace App\Http\Controllers\Partenaire\Annonce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Annonce;
use App\Models\Objet;
use App\Models\Categorie;
use App\Models\PaiementPartenaire;

class AnnonceController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id() ?? 1;

        $query = Annonce::with(['objet.evaluations']) // <-- updated line
            ->where('proprietaire_id', $userId)
            ->orderByDesc('created_at');

        // Filter by category (through objet)
        if ($request->filled('categorie_id')) {
            $query->whereHas('objet', function ($q) use ($request) {
                $q->where('categorie_id', $request->categorie_id);
            });
        }

        // Filter by etat (through objet)
        if ($request->filled('etat')) {
            $query->whereHas('objet', function ($q) use ($request) {
                $q->where('etat', $request->etat);
            });
        }

        if ($request->filled('tranche_age')) {
            $query->where('tranche_age', $request->tranche_age);
        }

        // Search by objet name
        if ($request->filled('search')) {
            $query->whereHas('objet', function ($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%');
            });
        }

        $annonces = $query->get();
        $categories = \App\Models\Categorie::all(); // for select options

        return view('partenaire.annonces.index', compact('annonces', 'categories'));
    }


    public function create()
    {
        // On ne passe pas d’objet ici, on oblige d’appeler chooseObject d’abord
        return redirect()->route('partenaire.annonces.choose');
    }

    public function choose(Request $request)
    {
        $userId = auth()->id() ?? 1;

        $objetsAvecAnnonce = Annonce::where('proprietaire_id', $userId)
            ->pluck('objet_id')
            ->toArray();

        $query = Objet::with('images', 'categorie')
            ->where('proprietaire_id', $userId)
            ->whereNotIn('id', $objetsAvecAnnonce);

        // Filters
        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        if ($request->filled('etat')) {
            $query->where('etat', $request->etat);
        }

        $objets = $query->get();
        $categories = Categorie::all();

        return view('partenaire.annonces.choose', compact('objets', 'categories'));
    }


    public function createForObject(Objet $objet)
    {
        return view('partenaire.annonces.create', compact('objet'));
    }

    public function store(Request $r)
    {
        $userId = auth()->id() ?? 1;

        $activeCount = Annonce::active()->where('proprietaire_id', $userId)->count();
        $exceedsLimit = $activeCount >= 5;

        // Validation complète
        $rules = [
            'objet_id' => ['required', 'exists:objets,id'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'prix_journalier' => ['required', 'numeric', 'min:0'],
            'date_debut' => ['required', 'date', 'after_or_equal:today'],
            'date_fin' => ['required', 'date', 'after:date_debut'],
            'premium' => ['nullable', 'boolean'],
            'premium_periode' => ['nullable', 'in:7,15,30'],
        ];

        // Si premium est coché on exige la période
        if ($r->filled('premium') && $r->premium) {
            $rules['premium_periode'] = ['required', 'in:7,15,30'];
        }

        $data = $r->validate($rules);

        $data['adresse'] = $data['latitude'] . ',' . $data['longitude'];
        $data['proprietaire_id'] = $userId;
        $data['date_publication'] = now();
        $data['statut'] = $exceedsLimit ? 'archivee' : 'active';


        // Premium ?
        if (isset($data['premium']) && $data['premium']) {
            $data['premium_start_date'] = now();
        } else {
            $data['premium'] = false;
            $data['premium_periode'] = null;
            $data['premium_start_date'] = null;
        }

        $annonce = Annonce::create($data);

        // 💵 Créer paiement partenaire si premium
        if ($annonce->premium && $annonce->premium_periode) {
            $premiumPrices = [
                '7' => 15,
                '15' => 25,
                '30' => 35,
            ];

            $tarif = $premiumPrices[$annonce->premium_periode];

            PaiementPartenaire::create([
                'annonce_id'    => $annonce->id,
                'partenaire_id' => $userId,
                'montant'       => $tarif,
                'methode'       => 'carte', // Or set dynamically later
                'date_paiement' => now(),
                'periode'       => $annonce->premium_periode,
            ]);
        }

        $message = $exceedsLimit
            ? 'Annonce créée, mais automatiquement archivée car vous avez déjà 5 annonces actives.'
            : 'Annonce créée 🎉';


        return redirect()->route('partenaire.annonces.index')->with('ok', $message);
    }


    public function edit(Annonce $annonce)
    {
        return view('partenaire.annonces.edit', compact('annonce'));
    }

    public function update(Request $r, Annonce $annonce)
    {
        // Règles de validation complètes
        $rules = [
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'prix_journalier' => ['required', 'numeric', 'min:0'],
            'date_debut' => ['required', 'date', 'after_or_equal:today'],
            'date_fin' => ['required', 'date', 'after:date_debut'],
            'premium' => ['nullable', 'boolean'],
            'premium_periode' => ['nullable', 'in:7,15,30'],
            'remove_premium' => ['nullable', 'boolean'],
        ];

        // Si l'utilisateur coche "Activer premium", la période est obligatoire
        if ($r->filled('premium') && $r->premium) {
            $rules['premium_periode'] = ['required', 'in:7,15,30'];
        }

        $data = $r->validate($rules);

        // Adresse toujours mise à jour
        $data['adresse'] = $data['latitude'] . ',' . $data['longitude'];

        // ✅ Cas 1 : Désactiver premium si coché
        if (isset($data['remove_premium']) && $data['remove_premium']) {
            $data['premium'] = false;
            $data['premium_periode'] = null;
            $data['premium_start_date'] = null;
        }
        // ✅ Cas 2 : Activer premium avec période choisie
        elseif (isset($data['premium']) && $data['premium']) {
            $data['premium'] = true;
            $data['premium_start_date'] = now();
            $data['premium_periode'] = $data['premium_periode']; // déjà validée
        }
        // ✅ Cas 3 : Rien ne change pour premium s’il n’y a pas de modification
        else {
            unset($data['premium']);
            unset($data['premium_periode']);
            unset($data['premium_start_date']);
        }

        $annonce->update($data);

        if (!empty($data['premium']) && !empty($data['premium_periode'])) {
            $premiumPrices = [
                '7' => 15,
                '15' => 25,
                '30' => 35,
            ];

            $tarif = $premiumPrices[$data['premium_periode']] ?? 0;

            PaiementPartenaire::create([
                'annonce_id'    => $annonce->id,
                'partenaire_id' => auth()->id() ?? 1,
                'montant'       => $tarif,
                'methode'       => 'carte', // Change if needed
                'date_paiement' => now(),
                'periode'       => $data['premium_periode'],
            ]);
        }

        return redirect()->route('partenaire.annonces.index')->with('ok', 'Annonce mise à jour avec succès.');
    }
    

    public function destroy(Annonce $annonce)
    {
        $annonce->delete();
        return redirect()->route('partenaire.annonces.index')->with('ok', 'Annonce supprimée.');
    }

    public function archiver(Annonce $annonce)
    {
        $annonce->update(['statut' => 'archivee']);
        return back()->with('ok', 'Annonce archivée.');
    }

    public function activer(Annonce $annonce)
    {
        $userId = auth()->id() ?? 1;

        if (Annonce::where('proprietaire_id', $userId)->where('statut', 'active')->count() >= 5) {
            return back()->withErrors([
                'limit' => 'Vous avez déjà 5 annonces actives.'
            ]);
        }

        $annonce->update(['statut' => 'active']);
        return back()->with('ok', 'Annonce activée.');
    }
}
