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
        Schema::create('anthropometries', function (Blueprint $table) {
            $table->id();
            $table->integer('weights_initial')->nullable();
            $table->integer('height')->nullable();
            $table->integer('body_fat')->nullable();
            $table->integer('body_muscle')->nullable();
            $table->enum('physical_activity_level', ['light, moderate, vigorous'])->nullable();
            $table->integer('TMB')->nullable();
            $table->integer('GET')->nullable();
            $table->text('lesions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anthropometries');
    }
};
