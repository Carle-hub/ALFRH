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
        Schema::create('absences', function (Blueprint $table) {
            $table->id(); // id
            $table->unsignedBigInteger('employe_id'); // Employé_id
            $table->string('type'); // Type
            $table->date('date_debut'); // Date début
            $table->date('date_retour'); // Date retour
            $table->integer('duree'); // Durée
            $table->string('justification')->nullable(); // Justification
            $table->date('date_approbation')->nullable(); // Date approbation
            $table->unsignedBigInteger('users_id'); // User_id
            $table->timestamps();

            // Foreign keys (optionnel, à activer si les tables existent)
            // $table->foreign('employe_id')->references('id')->on('employes')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
