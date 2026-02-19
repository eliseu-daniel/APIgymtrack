<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Workout;
use App\Models\WorkoutItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutItemFactory extends Factory
{
    protected $model = WorkoutItem::class;

    public function definition(): array
    {
        return [
            'workout_id' => Workout::factory(),
            'exercise_id' => Exercise::factory(),

            'day_of_week' => fake()->randomElement(['seg', 'ter', 'qua', 'qui', 'sex', 'sab', 'dom']),
            'series' => fake()->numberBetween(2, 6),
            'repetitions' => fake()->numberBetween(6, 20),

            'weight_load' => fake()->optional(0.6)->numberBetween(5, 120),
            'duration_time' => fake()->optional(0.4)->numberBetween(5, 90),
            'rest_time' => fake()->optional(0.6)->numberBetween(20, 180),

            'send_notification' => fake()->boolean(15),
            'is_active' => true,
        ];
    }
}
