<?php

namespace Tests\Feature;

use App\Models\Educator;
use App\Models\Patient;
use App\Models\PatientRegistration;
use App\Models\PatientWeight;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProgressTest extends TestCase
{
    use RefreshDatabase;

    private string $token;
    private Educator $educator;
    private Patient $patient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->educator = Educator::create([
            'name' => 'Test Educator',
            'email' => 'educator@test.com',
            'password' => Hash::make('password123'),
            'phone' => '11999999999',
            'is_active' => true,
        ]);

        $this->token = $this->educator->createToken('api-token')->plainTextToken;

        $this->patient = Patient::create([
            'name' => 'Test Patient',
            'email' => 'patient@test.com',
            'phone' => '11999999999',
            'is_active' => true,
        ]);

        PatientRegistration::create([
            'patient_id' => $this->patient->id,
            'educator_id' => $this->educator->id,
            'start_date' => now(),
        ]);
    }

    public function test_can_get_progress_for_patient(): void
    {
        PatientWeight::create([
            'patient_id' => $this->patient->id,
            'weight' => '80',
            'current_date' => now(),
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/educators/progress/reports?patient_id=' . $this->patient->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'diet' => ['weight', 'calories', 'tmb', 'bodyFat'],
                'workout' => ['weight', 'loads', 'repetitions', 'bodyFat'],
            ]);
    }

    public function test_progress_requires_patient_id(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/educators/progress/reports');

        $response->assertStatus(422);
    }

    public function test_can_list_progress_patients(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/educators/progress/patients');

        $response->assertStatus(200);
    }
}
