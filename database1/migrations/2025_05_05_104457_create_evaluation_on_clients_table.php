<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('evaluation_on_clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('utilisateurs')->cascadeOnDelete(); // Client évalué
            $table->foreignId('partner_id')->constrained('utilisateurs')->cascadeOnDelete(); // Partenaire évaluateur
            $table->tinyInteger('note');
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_on_clients');
    }
};
