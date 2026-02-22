<?php

namespace Database\Seeders;

use App\Models\Anthropometry;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnthropometrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();

        foreach ($patients as $patient) {
            Anthropometry::factory()->create([
                'patient_id' => $patient->id,
            ]);
        }
    }
}
