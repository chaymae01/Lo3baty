<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        Categorie::insert([
            ['nom' => 'Jouet Bébé'],
            ['nom' => 'Puzzle'],
            ['nom' => 'Lego'],
            ['nom' => 'Jeu de société'],
            ['nom' => 'Véhicules'],
        ]);
    }
}
