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
        Schema::create('treinos', function (Blueprint $table) {
            $table->integer('idTreino', true);
            $table->integer('idPaciente')->index('idpaciente');
            $table->integer('idAntropometria')->index('idantropometria');
            $table->date('inicioTreino');
            $table->string('tipoTreino', 50)->nullable();
            $table->string('grupoMuscular', 50)->nullable();
            $table->integer('seriesTreino')->nullable();
            $table->integer('repeticoesTreino')->nullable();
            $table->decimal('cargaInicial', 5)->nullable();
            $table->decimal('cargaAtual', 5)->nullable();
            $table->text('tempoDescanso')->nullable();
            $table->string('diaSemana', 50)->nullable();
            $table->text('linksExecucao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treinos');
    }
};
