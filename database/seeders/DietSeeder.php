<?php

namespace Database\Seeders;

use App\Models\Diet;
use App\Models\DietFeedback;
use App\Models\DietItem;
use App\Models\Meal;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class DietSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $meals = Meal::all();

        foreach ($patients as $patient) {
            $diet = Diet::factory()->create([
                'patient_id' => $patient->id,
                'meals_id' => $meals->random()->id,
            ]);

            DietItem::factory()->count(3)->create(['diet_id' => $diet->id]);
            DietFeedback::factory()->count(1)->create(['diet_id' => $diet->id]);
        }
    }
}
