<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReclamationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reclamation::with('utilisateur')
                    ->orderBy('created_at', 'desc');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $reclamations = $query->paginate(10);
        $statuts = ['en_attente', 'resolue'];

        return view('admin.reclamations.index', compact('reclamations', 'statuts'));
    }

    public function show(Reclamation $reclamation)
    {
        return view('admin.reclamations.show', compact('reclamation'));
    }

    public function repondre(Request $request, Reclamation $reclamation)
    {
        $request->validate([
            'reponse' => 'required|string|max:2000',
        ]);

        $reclamation->update([
            'reponse' => $request->reponse,
            'statut' => 'resolue',
            'date_reponse' => now(),
        ]);

        // Envoyer une notification à l'utilisateur

        return redirect()->route('admin.reclamations.index')
            ->with('success', 'Réponse envoyée avec succès!');
    }

    public function downloadPieceJointe(Reclamation $reclamation)
    {
        if ($reclamation->piece_jointe && Storage::exists($reclamation->piece_jointe)) {
            return Storage::download($reclamation->piece_jointe);
        }

        return back()->with('error', 'Fichier introuvable');
    }
}