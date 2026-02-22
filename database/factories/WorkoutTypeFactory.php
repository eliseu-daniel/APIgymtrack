<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkoutType>
 */
class WorkoutTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'workout_type' => fake()->unique()->randomElement([
                'Hipertrofia',
                'Emagrecimento',
                'Resistência',
                'Funcional',
                'Reabilitação',
                'Iniciante',
                'Intermediário',
                'Avançado',
                'Cardio',
                'Força'
            ]),
        ];
    }
}
