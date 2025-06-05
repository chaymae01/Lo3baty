<?php

namespace Database\Seeders;

use App\Models\EvaluationOnPartner;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EvaluationOnPartnerSeeder extends Seeder
{
    public function run(): void
    {
        EvaluationOnPartner::insert([
            [
                'partner_id' => 1,
                'client_id' => 2,
                'reservation_id' => 1,
                'note' => 5,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
                'commentaire' => 'Très bon service, partenaire sérieux !'
            ],
        ]);
    }
}
