<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    public function getSurnom($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        return response()->json(['surnom' => $utilisateur->surnom]);
    }
}