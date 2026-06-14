<?php

namespace Tests\Feature;

use App\Models\Administrator;
use App\Models\Exercise;
use App\Models\MuscleGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExerciseTest extends TestCase
{
    use RefreshDatabase;

    private string $token;
    private MuscleGroup $muscleGroup;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = Administrator::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'phone' => '11999999999',
            'is_active' => true,
            'is_admin' => true,
        ]);

        $this->token = $admin->createToken('admin-token')->plainTextToken;

        $this->muscleGroup = MuscleGroup::create(['muscle_group' => 'Peitoral']);
    }

    public function test_can_list_exercises(): void
    {
        Exercise::create([
            'muscle_group_id' => $this->muscleGroup->id,
            'exercise' => 'Supino Reto',
            'link_exercise' => 'https://example.com/supino',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/administrators/exercises');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'Exercises',
            ]);
    }

    public function test_can_create_exercise(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/administrators/exercises', [
            'muscle_group_id' => $this->muscleGroup->id,
            'exercise' => 'Supino Reto',
            'link_exercise' => 'https://example.com/supino',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
            ]);

        $this->assertDatabaseHas('exercises', [
            'exercise' => 'Supino Reto',
        ]);
    }

    public function test_can_show_exercise(): void
    {
        $exercise = Exercise::create([
            'muscle_group_id' => $this->muscleGroup->id,
            'exercise' => 'Supino Reto',
            'link_exercise' => 'https://example.com/supino',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson("/api/administrators/exercises/{$exercise->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

    public function test_returns_404_for_nonexistent_exercise(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/administrators/exercises/99999');

        $response->assertStatus(404);
    }
}
