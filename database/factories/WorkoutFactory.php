<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workout>
 */
class WorkoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'workout_type_id' => \App\Models\WorkoutType::inRandomOrder()->first()->id,
            'patient_id' => \App\Models\Patient::inRandomOrder()->first()->id,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'finalized_at' => null,
        ];
    }
}
