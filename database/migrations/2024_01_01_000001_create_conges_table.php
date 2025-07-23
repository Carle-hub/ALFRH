<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained('employes')->onDelete('cascade');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('duree');
            $table->text('commentaire')->nullable();
            $table->string('semestre')->nullable(); // Ajout de la colonne semestre
            $table->timestamp('date_demande')->nullable();
            $table->timestamp('date_approbation')->nullable();
            $table->foreignId('users_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('solde_conges')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conges');
    }
};