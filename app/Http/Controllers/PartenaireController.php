<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User; 

class PartenaireController extends Controller
{
    public function showContrat()
    {
        if (Auth::user()->role !== 'client') {
            return redirect()->route('home')
                           ->with('error', 'Vous êtes déjà partenaire.');
        }
        
        return view('partenaire.contrat');
    }
    public function devenirPartenaire(Request $request)
    {
        $validated = $request->validate([
            'cin_recto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'cin_verso' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'terms' => 'required|accepted'
        ]);
    
        /** @var \App\Models\User $user */
        $user = Auth::user();
    
        if ($user->role === 'partenaire') {
            return redirect()->route('partenaire.dashboard')
                           ->with('error', 'Vous êtes déjà partenaire.');
        }
    
        $rectoPath = $request->file('cin_recto')->store('cins', 'public');
        $versoPath = $request->file('cin_verso')->store('cins', 'public');
    
        $user->cin_recto = $rectoPath;
        $user->cin_verso = $versoPath;
        $user->role = 'partenaire';
        
        if (!$user->save()) {
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    
        return redirect()->route('partenaire.dashboard')
                       ->with('success', 'Félicitations ! Vous êtes maintenant partenaire.');
    }
    
    
    


    public function switchRole(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
    
        if ($request->input('role') === 'partenaire') {
            // Si l'utilisateur est déjà partenaire
            if ($user->role === 'partenaire') {
                return response()->json([
                    'success' => true,
                    'redirect' => route('partenaire.dashboard')
                ]);
            }
            
            // Si l'utilisateur est client mais n'a pas complété les documents
            if (!$user->cin_recto || !$user->cin_verso) {
                return response()->json([
                    'redirect' => route('partenaire.contrat'),
                    'completed' => false
                ]);
            }
            
            // Si client valide veut devenir partenaire
            $user->role = 'partenaire';
            $user->save();
            
            return response()->json([
                'success' => true,
                'redirect' => route('partenaire.dashboard')
            ]);
        }
        elseif ($request->input('role') === 'client') {
            // Même si c'est un partenaire, on le laisse voir l'interface client
            return response()->json([
                'success' => true,
                'redirect' => route('client.acceuil')
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Action non autorisée'
        ]);
    }
}
