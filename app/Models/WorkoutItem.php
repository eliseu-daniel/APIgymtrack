<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class WorkoutItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'workout_id',
        'exercise_id',
        'day_of_week',
        'series',
        'repetitions',
        'weight_load',
        'duration_time',
        'rest_time',
        'send_notification',
        'is_active',
    ];
}
