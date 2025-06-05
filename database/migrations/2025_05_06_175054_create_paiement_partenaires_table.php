<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paiements_partenaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->constrained()->onDelete('cascade');
            $table->foreignId('partenaire_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->decimal('montant', 8, 2);
            $table->string('methode');
            $table->timestamp('date_paiement');
            $table->enum('periode', ['7', '15', '30']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements_partenaires');
    }
};
