<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'muscle_group_id' => \App\Models\MuscleGroup::inRandomOrder()->first()->id,
            'exercise' => fake()->word(),
            'link_exercise' => fake()->url(),
        ];
    }
}
