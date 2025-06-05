<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
          Schema::create('reclamations', function (Blueprint $table) {
            $table->id();
            $table->string('sujet');
            $table->text('contenu');
            $table->text('reponse')->nullable();
             $table->enum('statut', ['en_attente', 'en_cours', 'resolue'])->default('en_attente');
            $table->string('piece_jointe')->nullable();
            $table->timestamp('date_reponse')->nullable();
            $table->unsignedBigInteger('utilisateur_id');
            $table->timestamps();
            $table->foreign('utilisateur_id')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('reclamations');
    }
};
