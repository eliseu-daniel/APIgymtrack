<?php

namespace Tests\Feature;

use App\Models\Educator;
use App\Models\Patient;
use App\Models\PatientRegistration;
use App\Models\Workout;
use App\Models\WorkoutType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WorkoutTest extends TestCase
{
    use RefreshDatabase;

    private string $token;
    private Educator $educator;
    private Patient $patient;
    private WorkoutType $workoutType;

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

        $this->workoutType = WorkoutType::create([
            'workout_type' => 'Hipertrofia',
        ]);
    }

    public function test_can_list_workouts(): void
    {
        Workout::create([
            'patient_id' => $this->patient->id,
            'workout_type_id' => $this->workoutType->id,
            'start_date' => now(),
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/educators/workouts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'WorkoutData',
            ]);
    }

    public function test_can_create_workout(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/educators/workouts', [
            'patient_id' => $this->patient->id,
            'workout_type_id' => $this->workoutType->id,
            'start_date' => now()->format('Y-m-d'),
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
            ]);

        $this->assertDatabaseHas('workouts', [
            'patient_id' => $this->patient->id,
        ]);
    }

    public function test_can_show_workout(): void
    {
        $workout = Workout::create([
            'patient_id' => $this->patient->id,
            'workout_type_id' => $this->workoutType->id,
            'start_date' => now(),
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson("/api/educators/workouts/{$workout->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

    public function test_can_delete_workout(): void
    {
        $workout = Workout::create([
            'patient_id' => $this->patient->id,
            'workout_type_id' => $this->workoutType->id,
            'start_date' => now(),
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/educators/workouts/{$workout->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);

        $this->assertDatabaseMissing('workouts', ['id' => $workout->id]);
    }

    public function test_patient_can_see_their_workouts(): void
    {
        Workout::create([
            'patient_id' => $this->patient->id,
            'workout_type_id' => $this->workoutType->id,
            'start_date' => now(),
        ]);

        $patientToken = $this->patient->createToken('patient-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $patientToken,
        ])->getJson('/api/patients/workouts');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }
}
