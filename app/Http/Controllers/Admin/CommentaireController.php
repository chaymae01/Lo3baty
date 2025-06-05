<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\EvaluationOnClients;
use App\Models\Admin\EvaluationOnPartners;
use App\Models\Admin\EvaluationOnAnnonces;
use Illuminate\Http\Request;
use App\Models\Admin\Commentaire;

class CommentaireController extends Controller
{
    public function index(Request $request)
    {
        // Récupération des paramètres de filtrage
        $filters = [
            'statut' => $request->input('statut'),
            'type' => $request->input('type')
        ];
    
        // Requêtes de base
        $queryClients = EvaluationOnClients::with(['client', 'partner', 'reservation'])
            ->orderBy('created_at', 'desc');
        
        $queryPartners = EvaluationOnPartners::with(['client', 'partner', 'reservation'])
            ->orderBy('created_at', 'desc');
            
        $queryAnnonces = EvaluationOnAnnonces::with(['client', 'objet'])
            ->orderBy('created_at', 'desc');
    
        // Filtrage par statut
        if ($filters['statut'] === 'signale') {
            $queryClients->where('is_flagged', true);
            $queryPartners->where('is_flagged', true);
            $queryAnnonces->where('is_flagged', true);
        } elseif ($filters['statut'] === 'publie') {
            $queryClients->where('is_flagged', false);
            $queryPartners->where('is_flagged', false);
            $queryAnnonces->where('is_flagged', false);
        }
    
        // Filtrage par type
        switch ($filters['type']) {
            case 'client_partenaire':
                $commentaires = $queryClients->get();
                break;
            case 'partenaire_client':
                $commentaires = $queryPartners->get();
                break;
            case 'annonce':
                $commentaires = $queryAnnonces->get();
                break;
            default:
                $commentaires = $queryClients->get()
                    ->concat($queryPartners->get())
                    ->concat($queryAnnonces->get())
                    ->sortByDesc('created_at');
        }
    
        return view('admin.commentaires.index', compact('commentaires'));
    }

    public function show($id)
    {
        $commentaire = EvaluationOnClients::with(['client', 'partner', 'reservation'])->find($id);
        $type = 'client_partenaire';
    
        if (!$commentaire) {
            $commentaire = EvaluationOnPartners::with(['client', 'partner', 'reservation'])->find($id);
            $type = 'partenaire_client';
        }
    
        if (!$commentaire) {
            $commentaire = EvaluationOnAnnonces::with(['client', 'objet'])->find($id);
            $type = 'annonce';
        }
    
        if (!$commentaire) {
            abort(404);
        }
    
        return view('admin.commentaires.show', compact('commentaire', 'type'));
    }
    

    public function approve($id)
    {
        $commentaire = EvaluationOnClients::find($id);
        
        if (!$commentaire) {
            $commentaire = EvaluationOnPartners::find($id);
        }
        
        if (!$commentaire) {
            $commentaire = EvaluationOnAnnonces::find($id);
        }

        $commentaire->update([
            'is_flagged' => false,
            'flag_reason' => null
        ]);

        return back()->with('success', 'Commentaire approuvé avec succès.');
    }

    public function destroy($id)
    {
        $commentaire = EvaluationOnClients::find($id);
        
        if (!$commentaire) {
            $commentaire = EvaluationOnPartners::find($id);
        }
        
        if (!$commentaire) {
            $commentaire = EvaluationOnAnnonces::find($id);
        }

        $commentaire->delete();

        return redirect()->route('admin.commentaires')
            ->with('success', 'Commentaire supprimé avec succès.');
    }
}