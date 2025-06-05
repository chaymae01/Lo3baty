<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use App\Models\Utilisateur;

class ProfileController extends Controller
{
    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        /** @var Utilisateur $user */
        $user = Auth::user();

        if ($user->image_profil) {
            Storage::disk('public')->delete($user->image_profil);
        }

        $imagePath = $request->file('image')->store('profile_images', 'public');

        $user->image_profil = $imagePath;
        $user->save();

        $fullUrl = asset(Storage::url($imagePath));

        return response()->json([
            'success' => true,
            'image_url' => $fullUrl,
            'message' => 'Image de profil mise à jour avec succès'
        ]);
    }

    public function updateInfo(Request $request)
{
    /** @var Utilisateur $user */
    $user = Auth::user();

    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'surnom' => 'nullable|string|max:50',
       
    ]);

    $user->nom = $request->nom;
    $user->prenom = $request->prenom;
    $user->surnom = $request->surnom;
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Profil mis à jour avec succès',
        'utilisateurs' => [
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'surnom' => $user->surnom,
            
        ]
    ]);
}
    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);

        /** @var Utilisateur $user */
        $user = Auth::user();

        $user->mot_de_passe = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Mot de passe mis à jour avec succès'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie',
            'redirect' => url('/')
        ]);
    }
}
