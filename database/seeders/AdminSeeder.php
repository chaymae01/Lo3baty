<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Création d'un administrateur
        Admin::create([
            'nom' => 'Admin',
            'prenom' => 'Test',
            'email' => 'admin@lo3baty.com',
            'mot_pass' => 'admin123',
            'created_at' => Carbon::now()->subDay(),
            'updated_at' => Carbon::now()->subDay(),
        ]);
    }
}
