<?php

namespace Database\Seeders;

use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    public function run()
    {
        // Création du 1 er utilisateur
        Utilisateur::create([
            'nom' => 'Bensaddik',
            'prenom' => 'Mohamed',
            'surnom' => 'm.bens',
            'email' => 'bensm@gmail.com',
            'mot_de_passe' => Hash::make('test1234'),
            'role' => 'client',
            'image_profil' => 'images/profils/profil.jpg', 
            'is_active' => true,
            'email_verified_at' => now(), 
        ]);

        Utilisateur::create([
            'nom' => 'Bensaddik',
            'prenom' => 'Omar',
            'surnom' => 'o.bens',
            'email' => 'benso@gmail.com',
            'mot_de_passe' => Hash::make('test1234'),
            'role' => 'client',
            'image_profil' => 'images/profils/profil.jpg', 
            'is_active' => true,
            'email_verified_at' => now(), 
        ]);
        
    }
}
