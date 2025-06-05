<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('evaluation_on_annonces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objet_id')->constrained('objets')->cascadeOnDelete(); // Annonce (Objet) évaluée
            $table->foreignId('client_id')->constrained('utilisateurs')->cascadeOnDelete(); // Client évaluateur
            $table->tinyInteger('note');
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_on_annonces');
    }
};
