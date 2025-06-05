<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        Image::insert([
            ['url' => 'images/objets/lego.jpg', 'objet_id' => 1],
            ['url' => 'images/objets/lego1.jpg', 'objet_id' => 1],
            ['url' => 'images/objets/voiture.jpg', 'objet_id' => 2],
            ['url' => 'images/objets/dob.jpg', 'objet_id'=>3]
        ]);
    }
}

