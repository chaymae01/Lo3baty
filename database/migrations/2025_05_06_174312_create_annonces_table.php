<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->date('date_publication');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->enum('statut', ['active', 'archivee'])->default('active');
            $table->decimal('prix_journalier', 8, 2);
            $table->boolean('premium')->default(false);
            $table->enum('premium_periode', ['7', '15', '30'])->nullable()->default(null);
            $table->timestamp('premium_start_date')->nullable();
            $table->string('adresse');
            $table->foreignId('objet_id')->constrained('objets')->cascadeOnDelete();
            $table->foreignId('proprietaire_id')->constrained('utilisateurs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
