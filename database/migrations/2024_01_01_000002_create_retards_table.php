<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('retards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employe_id')->nullable();
            $table->date('date')->nullable();
            $table->time('heure_prevue')->nullable();
            $table->time('heure_arrivee')->nullable();
            $table->integer('duree')->nullable(); // en minutes
            $table->string('justification')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('retards');
    }
};
