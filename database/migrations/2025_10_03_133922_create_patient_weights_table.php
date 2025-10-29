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
        Schema::create('patient_weights', function (Blueprint $table) {
            $table->id();
            $table->string('weight');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('current_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_weights');
    }
};
