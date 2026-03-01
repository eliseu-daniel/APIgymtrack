<?php

namespace Database\Factories;

use App\Models\Diet;
use App\Models\DietItem;
use App\Models\Food;
use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;

class DietItemFactory extends Factory
{
    protected $model = DietItem::class;

    public function definition(): array
    {
        return [
            'diet_id' => Diet::factory(),
            'food_id' => Food::factory(),
            'meals_id' => Meal::query()->inRandomOrder()->value('id') ?? 1,
            'meal_time' => fake()->time('H:i:s'),
            'quantity' => fake()->numberBetween(1, 300),
            'measure' => fake()->randomElement(['und', 'gr', 'ml', 'l']),
            'others' => fake()->optional()->sentence(3),
            'send_notification' => fake()->boolean(15),
            'is_active' => true,
        ];
    }
}
