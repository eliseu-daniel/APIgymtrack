<?php

namespace Database\Factories;

use App\Models\Diet;
use App\Models\DietFeedback;
use Illuminate\Database\Eloquent\Factories\Factory;

class DietFeedbackFactory extends Factory
{
    protected $model = DietFeedback::class;

    public function definition(): array
    {
        return [
            'diet_id' => Diet::factory(),
            'comment' => fake()->paragraph(),
            'send_notification' => fake()->boolean(15),
        ];
    }
}
