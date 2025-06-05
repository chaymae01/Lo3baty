<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    public function index(Request $request)
    {
        $query = Annonce::with(['objet', 'partenaire'])
            ->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $annonces = $query->paginate(10);
        $statuts = ['active', 'archive'];

        return view('admin.annonces.index', compact('annonces', 'statuts'));
    }

    public function show(Annonce $annonce)
    {
        $annonce->load(['objet', 'partenaire']);
        return view('admin.annonces.show', compact('annonce'));
    }
}