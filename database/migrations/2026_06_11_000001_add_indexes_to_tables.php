<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('educators', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('workouts', function (Blueprint $table) {
            $table->index('patient_id');
            $table->index('workout_type_id');
            $table->index('start_date');
        });

        Schema::table('workout_items', function (Blueprint $table) {
            $table->index('workout_id');
            $table->index('exercise_id');
            $table->index('day_of_week');
            $table->index('is_active');
        });

        Schema::table('diets', function (Blueprint $table) {
            $table->index('patient_id');
            $table->index('start_date');
        });

        Schema::table('diet_items', function (Blueprint $table) {
            $table->index('diet_id');
            $table->index('food_id');
            $table->index('meals_id');
            $table->index('meal_time');
            $table->index('is_active');
        });

        Schema::table('patient_weights', function (Blueprint $table) {
            $table->index('patient_id');
            $table->index('current_date');
        });

        Schema::table('patient_registrations', function (Blueprint $table) {
            $table->index('patient_id');
            $table->index('educator_id');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->index('patient_id');
            $table->index('educator_id');
            $table->index('type');
            $table->index('read');
        });

        Schema::table('exercises', function (Blueprint $table) {
            $table->index('muscle_group_id');
        });

        Schema::table('anthropometries', function (Blueprint $table) {
            $table->index('patient_id');
        });

        Schema::table('workout_feedback', function (Blueprint $table) {
            $table->index('workout_item_id');
        });

        Schema::table('diet_feedback', function (Blueprint $table) {
            $table->index('diet_id');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('educators', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('workouts', function (Blueprint $table) {
            $table->dropIndex(['patient_id']);
            $table->dropIndex(['workout_type_id']);
            $table->dropIndex(['start_date']);
        });

        Schema::table('workout_items', function (Blueprint $table) {
            $table->dropIndex(['workout_id']);
            $table->dropIndex(['exercise_id']);
            $table->dropIndex(['day_of_week']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('diets', function (Blueprint $table) {
            $table->dropIndex(['patient_id']);
            $table->dropIndex(['start_date']);
        });

        Schema::table('diet_items', function (Blueprint $table) {
            $table->dropIndex(['diet_id']);
            $table->dropIndex(['food_id']);
            $table->dropIndex(['meals_id']);
            $table->dropIndex(['meal_time']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('patient_weights', function (Blueprint $table) {
            $table->dropIndex(['patient_id']);
            $table->dropIndex(['current_date']);
        });

        Schema::table('patient_registrations', function (Blueprint $table) {
            $table->dropIndex(['patient_id']);
            $table->dropIndex(['educator_id']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['patient_id']);
            $table->dropIndex(['educator_id']);
            $table->dropIndex(['type']);
            $table->dropIndex(['read']);
        });

        Schema::table('exercises', function (Blueprint $table) {
            $table->dropIndex(['muscle_group_id']);
        });

        Schema::table('anthropometries', function (Blueprint $table) {
            $table->dropIndex(['patient_id']);
        });

        Schema::table('workout_feedback', function (Blueprint $table) {
            $table->dropIndex(['workout_item_id']);
        });

        Schema::table('diet_feedback', function (Blueprint $table) {
            $table->dropIndex(['diet_id']);
        });
    }
};
