<?php

namespace Database\Factories;

use App\Models\Educator;
use App\Models\Patient;
use App\Models\PatientRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientRegistration>
 */
class PatientRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PatientRegistration::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-60 days', 'now');
        $end = (clone $start)->modify('+30 days');

        $finalized = fake()->optional(0.6)->dateTimeBetween($start, $end);

        return [
            'patient_id' => Patient::factory(),
            'educator_id' => Educator::factory(),

            'plan_description' => fake()->randomElement(['monthly', 'quarterly', 'semiannual']),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),

            'finalized_at' => $finalized ? $finalized->format('Y-m-d') : null,
        ];
    }
}
