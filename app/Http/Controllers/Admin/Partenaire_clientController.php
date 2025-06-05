<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class Partenaire_clientController extends Controller
{
    // Affichage des partenaires
    public function indexPartenaires(Request $request)
    {
        $query = Utilisateur::where('role', 'partenaire');
    
        if ($request->filled('surnom')) {
            $query->where('surnom', 'like', '%' . $request->surnom . '%');
        }
    
        if ($request->filled('statut')) {
            $query->where('is_active', $request->is_active === 'actif' ? 1 : 0);
        }
    
        $partenaires = $query->orderBy('created_at', 'desc')->paginate(10);
    
        return view('admin.partenaires.index', compact('partenaires'));
    }

    // Affichage des clients
    public function indexClients(Request $request)
    {
        $query = Utilisateur::where('role', 'client');
    
        if ($request->filled('surnom')) {
            $query->where('surnom', 'like', '%' . $request->surnom . '%');
        }
    
        if ($request->filled('statut')) {
            $query->where('is_active', $request->statut === 'actif' ? 1 : 0);
        }
    
        $clients = $query->orderBy('created_at', 'desc')->paginate(10);
    
        return view('admin.clients.index', compact('clients'));
    }

    // Toggle status pour les partenaires
    public function toggleStatusPartenaire(Utilisateur $partenaire)
    {
        $partenaire->isActive() ? $partenaire->deactivate() : $partenaire->activate();

        return back()->with(
            'success',
            $partenaire->isActive() 
                ? 'Compte activé avec succès' 
                : 'Compte désactivé avec succès'
        );
    }

    // Toggle status pour les clients
    public function toggleStatusClient(Utilisateur $client)
    {
        $client->isActive() ? $client->deactivate() : $client->activate();

        return back()->with(
            'success',
            $client->isActive() 
                ? 'Compte activé avec succès'
                : 'Compte désactivé avec succès'
        );
    }
}
