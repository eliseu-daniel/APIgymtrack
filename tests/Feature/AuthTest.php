<?php

namespace Tests\Feature;

use App\Models\Educator;
use App\Models\Patient;
use App\Models\Administrator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_educator_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test Educator',
            'email' => 'educator@test.com',
            'password' => 'password123',
            'phone' => '11999999999',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Educador cadastrado com sucesso',
            ]);

        $this->assertDatabaseHas('educators', [
            'email' => 'educator@test.com',
        ]);
    }

    public function test_educator_can_login(): void
    {
        Educator::create([
            'name' => 'Test Educator',
            'email' => 'educator@test.com',
            'password' => Hash::make('password123'),
            'phone' => '11999999999',
            'is_active' => true,
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'educator@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'token',
                'educator',
            ]);
    }

    public function test_educator_login_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(404);
    }

    public function test_patient_can_login(): void
    {
        $patient = Patient::create([
            'name' => 'Test Patient',
            'email' => 'patient@test.com',
            'phone' => '11999999999',
            'is_active' => true,
        ]);

        $response = $this->postJson('/api/loginPatient', [
            'email' => 'patient@test.com',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'token',
                'patient',
            ]);
    }

    public function test_administrator_can_login(): void
    {
        Administrator::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'phone' => '11999999999',
            'is_active' => true,
            'is_admin' => true,
        ]);

        $response = $this->postJson('/api/loginAdministrator', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'token',
                'administrator',
            ]);
    }
}
