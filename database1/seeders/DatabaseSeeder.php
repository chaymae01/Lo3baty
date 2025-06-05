<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->call([
            CategorieSeeder::class,
            UtilisateurSeeder::class,
            ObjetSeeder::class,
            ImageSeeder::class,
            AnnonceSeeder::class,
            ReservationSeeder::class,
            EvaluationOnPartnerSeeder::class,
            EvaluationOnClientSeeder::class,
            EvaluationOnAnnonceSeeder::class,
            ReclamationSeeder::class,
            NotificationSeeder::class,
            PaiementClientSeeder::class,
            PaiementPartenaireSeeder::class,
        ]);
    }
}
