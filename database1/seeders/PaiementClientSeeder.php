<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaiementClient;
use Carbon\Carbon;

class PaiementClientSeeder extends Seeder
{
    public function run(): void
    {
        PaiementClient::insert([
            [
                'reservation_id' => 1,
                'client_id' => 2,
                'montant' => 150.00,
                'methode' => 'especes',
                'date_paiement' => Carbon::now()->subDays(3),
                'etat' => 'effectué',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reservation_id' => 2,
                'client_id' => 2,
                'montant' => 300.00,
                'methode' => 'paypal',
                'date_paiement' => Carbon::now()->subDays(1),
                'etat' => 'en_attente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
