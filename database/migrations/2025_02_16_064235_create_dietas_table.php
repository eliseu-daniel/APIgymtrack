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
        Schema::create('dietas', function (Blueprint $table) {
            $table->integer('idDieta', true);
            $table->integer('idPaciente')->index('idpaciente');
            $table->integer('idAntropometria')->nullable()->index('idantropometria');
            $table->date('inicioDieta');
            $table->string('horarioRefeicao', 6);
            $table->string('tipoDieta', 50)->nullable();
            $table->decimal('pesoAtual', 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dietas');
    }
};
