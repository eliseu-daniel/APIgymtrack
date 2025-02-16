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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('idUsuario', true);
            $table->string('nomeUsuario', 100);
            $table->string('telefoneUsuario', 15);
            $table->string('emailUsuario', 100)->unique('emailusuario');
            $table->text('senhaUsuario');
            $table->enum('tipoUsuario', ['admin', 'usuario']);
            $table->enum('tipoPlanoUsuario', ['free', 'pago'])->nullable();
            $table->enum('pagamentoUsuario', ['S', 'N'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
