<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_type_id',
        'patient_id',
        'start_date',
        'end_date',
        'finalized_at',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(WorkoutItem::class, 'workout_id');
    }

    public function workoutType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(WorkoutType::class, 'workout_type_id');
    }
}
