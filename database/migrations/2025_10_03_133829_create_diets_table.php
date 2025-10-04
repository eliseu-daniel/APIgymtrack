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
        Schema::create('diets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('meals_id')->constrained('meals')->onDelete('cascade');
            $table->time('meal_time');
            $table->string('diet_type')->nullable();
            $table->string('goal_weight')->nullable();
            $table->string('objective')->nullable();
            $table->integer('calories');
            $table->integer('proteins');
            $table->integer('carbohydrates');
            $table->integer('fats');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('finalized_at');           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diets');
    }
};
