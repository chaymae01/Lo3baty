<?php

namespace Database\Seeders;

use App\Models\Objet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ObjetSeeder extends Seeder
{
    public function run(): void
    {
        Objet::insert([
            [
                'nom' => 'Lego Star Wars',
                'description' => 'Un set complet de Lego Star Wars.',
                'ville' => 'Tétouan',
                'etat' => 'Neuf',
                'categorie_id' => 3,
                'proprietaire_id' => 1,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
            [
                'nom' => 'Voiture télécommandée',
                'description' => 'Voiture rapide et résistante.',
                'ville' => 'Tétouan',
                'etat' => 'Bon état',
                'categorie_id' => 5,
                'proprietaire_id' => 1,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
                
                
            ],
            [
                'nom' => 'Voiture rouge',
                'description' => 'Voiture rapide.',
                'ville' => 'Tétouan',
                'etat' => 'Usage',
                'categorie_id' => 3,
                'proprietaire_id' => 1,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
        ]);
    }
}

