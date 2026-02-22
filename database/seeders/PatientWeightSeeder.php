<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\PatientWeight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientWeightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();

        foreach ($patients as $patient) {
            PatientWeight::factory()->count(5)->create([
                'patient_id' => $patient->id,
            ]);
        }
    }
}
