<?php

namespace Tests\Feature;

use App\Models\Diet;
use App\Models\Educator;
use App\Models\Patient;
use App\Models\PatientRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DietTest extends TestCase
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

    public function test_can_list_diets(): void
    {
        Diet::create([
            'patient_id' => $this->patient->id,
            'calories' => 2000,
            'proteins' => 150,
            'carbohydrates' => 250,
            'fats' => 50,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/educators/diets');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'diets',
            ]);
    }

    public function test_can_create_diet(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/educators/diets', [
            'patient_id' => $this->patient->id,
            'calories' => 2000,
            'proteins' => 150,
            'carbohydrates' => 250,
            'fats' => 50,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(30)->format('Y-m-d'),
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
            ]);

        $this->assertDatabaseHas('diets', [
            'patient_id' => $this->patient->id,
        ]);
    }

    public function test_can_finalize_diet(): void
    {
        $diet = Diet::create([
            'patient_id' => $this->patient->id,
            'calories' => 2000,
            'proteins' => 150,
            'carbohydrates' => 250,
            'fats' => 50,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/educators/diets/{$diet->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Dieta finalizada com sucesso',
            ]);

        $this->assertNotNull($diet->fresh()->finalized_at);
    }

    public function test_patient_can_see_their_diets(): void
    {
        Diet::create([
            'patient_id' => $this->patient->id,
            'calories' => 2000,
            'proteins' => 150,
            'carbohydrates' => 250,
            'fats' => 50,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
        ]);

        $patientToken = $this->patient->createToken('patient-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $patientToken,
        ])->getJson('/api/patients/diets');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'diets',
            ]);
    }
}
