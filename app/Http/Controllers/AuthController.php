<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
  public function showRegisterForm()
  {
    return view('auth.register');
  }

  public function register(Request $request)
  {
    $request->validate([
      'nom' => 'required|string|max:255',
      'prenom' => 'required|string|max:255',
      'surnom' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:utilisateurs',
      'mot_de_passe' => 'required|string|min:8|confirmed',
      'image_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image_profil')) {
      $imagePath = $request->file('image_profil')->store('profile_images', 'public');
    }

    $user = Utilisateur::create([
        'nom'          => $request->nom,
        'prenom'       => $request->prenom,
        'surnom'       => $request->surnom,
        'email'        => $request->email,
        'mot_de_passe' => $request->mot_de_passe,
        'image_profil' => $imagePath,
    ]);

    Auth::login($user);

    return redirect()->route('annonces')->with('success', 'Inscription réussie!');
  }

  public function showLoginForm()
  {
    return view('auth.login');
  }

  public function login(Request $request)
  {
      $credentials = $request->validate([
          'email'        => 'required|email',
          'mot_de_passe' => 'required',
      ]);

      /* IMPORTANT : la clé doit s’appeler 'password', pas 'mot_de_passe' */
      if (Auth::attempt([
              'email'    => $credentials['email'],
              'password' => $credentials['mot_de_passe'],
          ])) {

          // Vérification du statut explicite
          $user = Auth::user();
          if (!$user->is_active) {
              Auth::logout();
              return back()->withErrors([
                  'email' => 'Votre compte est désactivé. Veuillez contacter l’administrateur.',
              ]);
          }

          $request->session()->regenerate();
          return redirect()->intended(route('annonces'))->with('success', 'Connexion réussie !');
      }

      return back()->withErrors([
          'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
      ]);
  }


  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
  }

  public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'surnom' => 'required|string|max:255|unique:utilisateurs,surnom,' . $user->id,
        'image_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image_profil')) {
        // Supprimer l'ancienne image si elle existe
        if ($user->image_profil) {
            Storage::disk('public')->delete($user->image_profil);
        }
        $user->image_profil = $request->file('image_profil')->store('profile_images', 'public');
    }

    $user->update([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'surnom' => $request->surnom,
        'image_profil' => $user->image_profil,
    ]);

    return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
}
}