<?php

namespace Database\Seeders;

use App\Models\EvaluationOnClient;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EvaluationOnClientSeeder extends Seeder
{
    public function run(): void
    {
        EvaluationOnClient::insert([
            [
                'client_id' => 2,
                'partner_id' => 1,
                'reservation_id' => 1,
                'note' => 4,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
                'commentaire' => 'Client ponctuel, respectueux du matériel.'
            ],
        ]);
    }
}
