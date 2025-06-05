<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('utilisateurs')->cascadeOnDelete();
            $table->foreignId('annonce_id')->constrained('annonces')->cascadeOnDelete();
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->boolean('is_email')->default(0);
            $table->enum('statut', ['en_attente', 'confirmée', 'refusée'])->default('en_attente');
            $table->date('evaluation_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
