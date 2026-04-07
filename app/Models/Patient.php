<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Patient extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
        'gender',
        'allergies',
        'is_active',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(PatientRegistration::class, 'patient_id');
    }

    public function diets(): HasMany
    {
        return $this->hasMany(Diet::class, 'patient_id');
    }

    public function workouts(): HasMany
    {
        return $this->hasMany(Workout::class, 'patient_id');
    }
}
