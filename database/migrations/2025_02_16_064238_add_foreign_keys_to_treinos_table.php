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
        Schema::table('treinos', function (Blueprint $table) {
            $table->foreign(['idPaciente'], 'treinos_ibfk_1')->references(['idPaciente'])->on('pacientes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['idAntropometria'], 'treinos_ibfk_2')->references(['idAntropometria'])->on('antropometria')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('treinos', function (Blueprint $table) {
            $table->dropForeign('treinos_ibfk_1');
            $table->dropForeign('treinos_ibfk_2');
        });
    }
};
