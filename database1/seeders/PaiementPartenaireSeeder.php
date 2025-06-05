<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaiementPartenaire;
use Carbon\Carbon;

class PaiementPartenaireSeeder extends Seeder
{
    public function run(): void
    {
        PaiementPartenaire::insert([
            [
                'annonce_id' => 1,
                'partenaire_id' => 1,
                'montant' => 35.00,
                'methode' => 'carte',
                'date_paiement' => Carbon::now()->subDays(2),
                'periode' => '7',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'annonce_id' => 2,
                'partenaire_id' => 1,
                'montant' => 25.00,
                'methode' => 'paypal',
                'date_paiement' => Carbon::now()->subDay(),
                'periode' => '15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
