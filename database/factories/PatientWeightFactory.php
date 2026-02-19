<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\PatientWeight;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientWeightFactory extends Factory
{
    protected $model = PatientWeight::class;

    public function definition(): array
    {
        return [
            'weight' => (string) fake()->randomFloat(1, 45, 160),
            'patient_id' => Patient::factory(),
            'current_date' => fake()->date(),
        ];
    }
}
