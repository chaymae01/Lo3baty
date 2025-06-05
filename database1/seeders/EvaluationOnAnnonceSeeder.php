<?php

namespace Database\Seeders;

use App\Models\EvaluationOnAnnonce;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EvaluationOnAnnonceSeeder extends Seeder
{
    public function run(): void
    {
        EvaluationOnAnnonce::insert([
            [
                'client_id' => 2,
                'objet_id' => 1,
                'note' => 5,
                'commentaire' => 'L\'objet était exactement comme décrit, parfait.',
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
        ]);
    }
}
