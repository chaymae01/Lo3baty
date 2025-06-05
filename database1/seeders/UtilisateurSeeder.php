<?php

namespace Database\Seeders;

use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UtilisateurSeeder extends Seeder
{
    public function run()
    {
        // Création du 1 er utilisateur
        Utilisateur::create([
            'nom' => 'Bensaddik',
            'prenom' => 'Med',
            'surnom' => 'bensm',
            'email' => 'mbens@gmail.com',
            'mot_de_passe' => 'test1234',
            'role' => 'client',
            'image_profil' => 'images/profils/profil.jpg', 
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => Carbon::now()->subDay(),
            'updated_at' => Carbon::now()->subDay(),
        ]);

        // Création du 2 eme utilisateur
        Utilisateur::create([
            'nom' => 'test',
            'prenom' => 'test2',
            'surnom' => 'test2',
            'email' => 'test2@gmail.com',
            'mot_de_passe' => 'test1234',
            'role' => 'client',
            'image_profil' => 'images/profils/profil.jpg', 
            'is_active' => true,
            'email_verified_at' => now(), 
            'created_at' => Carbon::now()->subDay(),
            'updated_at' => Carbon::now()->subDay(),
        ]);

         Utilisateur::create([
            'nom' => 'med',
            'prenom' => 'tes',
            'surnom' => 'test3',
            'email' => 'test3@gmail.com',
            'mot_de_passe' => 'test1234',
            'role' => 'client',
            'image_profil' => 'images/profils/profil.jpg', 
            'is_active' => true,
            'email_verified_at' => now(), 
            'created_at' => Carbon::now()->subDay(),
            'updated_at' => Carbon::now()->subDay(),
        ]);
    }
}
