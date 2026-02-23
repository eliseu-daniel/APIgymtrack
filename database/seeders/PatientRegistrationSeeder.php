<?php

namespace Database\Seeders;

use App\Models\Educator;
use App\Models\Patient;
use App\Models\PatientRegistration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $educators = Educator::all();

        $educatorsLimited = $educators->take(10);

        foreach ($patients as $patient) {
            PatientRegistration::factory()->create([
                'patient_id' => $patient->id,
                'educator_id' => $educatorsLimited->random()->id,
                'plan_description' => 'monthly',
                'start_date' => now(),
            ]);
        }
    }
}
