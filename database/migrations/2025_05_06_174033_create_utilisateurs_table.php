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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('surnom')->unique();
            $table->string('email', 100)->unique();
            $table->string('mot_de_passe');
            $table->enum('role', ['client', 'partenaire'])->default('client');
            $table->string('image_profil')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('cin_recto')->nullable();
            $table->string('cin_verso')->nullable();
             $table->enum('notification_annonce', ['active', 'desactive'])->default('active');
            $table->timestamp('email_verified_at')->nullable();
            //$table->rememberToken();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
