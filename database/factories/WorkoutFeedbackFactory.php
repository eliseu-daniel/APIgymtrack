<?php

namespace Database\Factories;

use App\Models\WorkoutFeedback;
use App\Models\WorkoutItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutFeedbackFactory extends Factory
{
    protected $model = WorkoutFeedback::class;

    public function definition(): array
    {
        return [
            'workout_item_id' => WorkoutItem::factory(),
            'comment' => fake()->paragraph(),
            'send_notification' => fake()->boolean(5),
        ];
    }
}
