<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anthropometry>
 */
class AnthropometryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'weights_initial' => fake()->numberBetween(60, 120),
            'height' => fake()->numberBetween(150, 190),
            'body_fat' => fake()->numberBetween(10, 30),
            'body_muscle' => fake()->numberBetween(30, 50),
            'physical_activity_level' => fake()->randomElement(['light', 'moderate', 'intense']),
            'TMB' => fake()->numberBetween(1400, 2200),
            'GET' => fake()->numberBetween(1800, 3000),
            'lesions' => fake()->optional()->sentence(),
            'is_active' => true,
        ];
    }
}
