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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->integer('idPaciente', true);
            $table->integer('idUsuario')->index('idusuario');
            $table->string('nomePaciente', 100);
            $table->string('emailPaciente', 50)->unique('emailpaciente');
            $table->string('telefonePaciente', 15);
            $table->date('nascimentoPaciente');
            $table->string('planoAcompanhamento', 100);
            $table->date('inicioAcompanhamento')->nullable();
            $table->date('fimAcompanhamento')->nullable();
            $table->enum('sexoPaciente', ['F', 'M'])->nullable();
            $table->string('pagamento', 100);
            $table->string('alergias', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
