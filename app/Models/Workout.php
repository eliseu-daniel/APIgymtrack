<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = [
        'workout_type_id',
        'patient_id',
        'start_date',
        'end_date',
        'finalized_at',
    ];
}
