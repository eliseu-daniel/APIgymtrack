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
        Schema::create('antropometria', function (Blueprint $table) {
            $table->integer('idAntropometria', true);
            $table->integer('idPaciente')->index('idpaciente');
            $table->decimal('pesoInicial', 5);
            $table->double('altura');
            $table->decimal('gorduraCorporal', 5);
            $table->string('nivelAtvFisica', 50)->nullable();
            $table->string('objetivo', 50)->nullable();
            $table->decimal('tmb', 5)->nullable();
            $table->integer('getAntro')->nullable();
            $table->string('lesoes', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antropometria');
    }
};
