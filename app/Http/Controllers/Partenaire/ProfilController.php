<?php

namespace App\Http\Controllers\Partenaire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function edit()
    {
        //$user = auth()->id() ?? 1;
        $user = Auth::user();
        return view('partenaire.profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();


        $data = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'surnom' => 'required|string|max:50|unique:utilisateurs,surnom,' . $user->id,
            'mot_de_passe' => 'nullable|string|min:6',
            'image_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cin_recto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cin_verso' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload image de profil
        if ($request->hasFile('image_profil')) {
            if ($user->image_profil) {
                Storage::disk('public')->delete($user->image_profil);
            }
            $data['image_profil'] = $request->file('image_profil')->store('profile_images', 'public');
        }

        // CIN recto
        if ($request->hasFile('cin_recto')) {
            if ($user->cin_recto) {
                Storage::disk('public')->delete($user->cin_recto);
            }
            $data['cin_recto'] = $request->file('cin_recto')->store('cin', 'public');
        }

        // CIN verso
        if ($request->hasFile('cin_verso')) {
            if ($user->cin_verso) {
                Storage::disk('public')->delete($user->cin_verso);
            }
            $data['cin_verso'] = $request->file('cin_verso')->store('cin', 'public');
        }

        // Mot de passe (via mutator)
        if (empty($data['mot_de_passe'])) {
            unset($data['mot_de_passe']);
        }

        $user->update($data);

        return back()->with('ok', 'Profil mis à jour avec succès ✅');
    }
}
