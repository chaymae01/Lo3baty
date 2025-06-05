<?php

namespace Database\Seeders;

use App\Models\Annonce;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AnnonceSeeder extends Seeder
{
    public function run(): void
    {
        Annonce::insert([
            [
                'objet_id' => 1,
                'proprietaire_id' => 1,
                'prix_journalier' => 50.00,
                'premium' => true,
                'premium_periode' => '7',
                'premium_start_date' => Carbon::now(),
                'date_publication' => Carbon::now(),
                'date_debut' => Carbon::now(),
                'date_fin' => Carbon::now()->addMonths(3),
                'statut' => 'active',
                'adresse' => 'Rue des Jouets, Tétouan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'objet_id' => 2,
                'proprietaire_id' => 1,
                'prix_journalier' => 30.00,
                'premium' => false,
                'premium_periode' => null,
                'premium_start_date' => null,
                'date_publication' => Carbon::now(),
                'date_debut' => Carbon::now(),
                'date_fin' => Carbon::now()->addMonths(3),
                'statut' => 'active',
                'adresse' => 'Rue des Jouets, Tétouan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'objet_id' => 3,
                'proprietaire_id' => 1,
                'prix_journalier' => 60.00,
                'premium' => false,
                'premium_periode' => null,
                'premium_start_date' => null,
                'date_publication' => Carbon::now(),
                'date_debut' => Carbon::now(),
                'date_fin' => Carbon::now()->addMonths(3),
                'statut' => 'archivee',
                'adresse' => 'Rue des Jouets, Fes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
