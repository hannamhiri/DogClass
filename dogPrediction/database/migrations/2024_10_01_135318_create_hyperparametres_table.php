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
        Schema::create('hyperparametres', function (Blueprint $table) {
            $table->id();
            $table->integer('taux_app');
            $table->integer('nb_epoque');
            $table->integer('taille_lot');
            $table->integer('patience');
            $table->string('monitor');
            $table->string('optimiseur');
            $table->string('nom_modele');
            $table->string('f_activation');
            $table->decimal('Val_split');
            $table->decimal('test_split');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hyperparametres');
    }
};
