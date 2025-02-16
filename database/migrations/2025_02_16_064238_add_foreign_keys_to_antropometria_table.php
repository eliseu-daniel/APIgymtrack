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
        Schema::table('antropometria', function (Blueprint $table) {
            $table->foreign(['idPaciente'], 'antropometria_ibfk_1')->references(['idPaciente'])->on('pacientes')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antropometria', function (Blueprint $table) {
            $table->dropForeign('antropometria_ibfk_1');
        });
    }
};
