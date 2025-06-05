<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('utilisateurs')->cascadeOnDelete();
            $table->foreignId('annonce_id')->constrained('annonces')->cascadeOnDelete();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('is_email')->default(0);
            $table->enum('statut', ['en_attente', 'confirmée', 'refusée'])->default('en_attente');
            $table->date('evaluation_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
