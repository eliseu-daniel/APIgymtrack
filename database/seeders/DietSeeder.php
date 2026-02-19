<?php

namespace Database\Seeders;

use App\Models\Diet;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DietSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $meals = Meal::all();

        foreach ($patients as $patient) {
            Diet::factory()->create([
                'patient_id' => $patient->id,
                'meals_id' => $meals->random()->id,
            ]);
        }
    }
}
