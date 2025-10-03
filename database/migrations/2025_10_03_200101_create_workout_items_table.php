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
        Schema::create('workout_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_id')->constrained('workouts')->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->string('day_of_week');
            $table->num('series');
            $table->num('repetitions');
            $table->num('weight_load')->nullable();
            $table->num('duration_time')->nullable();
            $table->num('rest_time')->nullable();
            $table->boolean('send_notification')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_items');
    }
};
