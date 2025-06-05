<?php

namespace Database\Seeders;

use App\Models\Reclamation;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReclamationSeeder extends Seeder
{
    public function run(): void
    {
        Reclamation::insert([
            [
                'utilisateur_id' => 1,
                'sujet' => 'Objet endommagé',
                'contenu' => 'L\'objet ne correspond pas à la description.',
                'statut' => 'en_cours',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}