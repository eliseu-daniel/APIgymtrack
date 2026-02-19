<?php

namespace Database\Factories;

use App\Models\Diet;
use App\Models\Meal;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class DietFactory extends Factory
{
    protected $model = Diet::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-10 days', '+10 days');
        $end = (clone $start)->modify('+30 days');

        return [
            'patient_id' => Patient::factory(),
            'meals_id' => Meal::query()->inRandomOrder()->value('id') ?? 1,

            'meal_time' => fake()->time('H:i:s'),

            'diet_type' => fake()->optional()->word(),
            'goal_weight' => fake()->optional()->randomFloat(1, 45, 140),
            'objective' => fake()->optional()->sentence(6),

            'calories' => fake()->numberBetween(1200, 3500),
            'proteins' => fake()->numberBetween(60, 220),
            'carbohydrates' => fake()->numberBetween(80, 450),
            'fats' => fake()->numberBetween(30, 150),

            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),

            // sua migration exige (não é nullable), então precisa vir preenchido
            'finalized_at' => fake()->dateTimeBetween('-5 days', '+40 days')->format('Y-m-d'),
        ];
    }
}
