<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paiements_clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->decimal('montant', 8, 2);
            $table->enum('methode', ['paypal', 'especes', 'carte']);
            $table->timestamp('date_paiement');
            $table->enum('etat', ['effectué', 'annulé', 'en_attente'])->default('en_attente');
            $table->boolean('livraison')->default(0);
            $table->decimal('montant_livraison', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements_clients');
    }
};
