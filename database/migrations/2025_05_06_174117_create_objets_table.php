<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('objets', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->enum('tranche_age', ['<3','3-5','6-8','9-12','13+']);
            $table->string('ville');
            $table->enum('etat', ['Neuf', 'Bon état', 'Usage']);
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('proprietaire_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('objets');
    }

};
