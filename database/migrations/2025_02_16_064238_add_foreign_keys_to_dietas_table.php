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
        Schema::table('dietas', function (Blueprint $table) {
            $table->foreign(['idPaciente'], 'dietas_ibfk_1')->references(['idPaciente'])->on('pacientes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['idAntropometria'], 'dietas_ibfk_2')->references(['idAntropometria'])->on('antropometria')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dietas', function (Blueprint $table) {
            $table->dropForeign('dietas_ibfk_1');
            $table->dropForeign('dietas_ibfk_2');
        });
    }
};
