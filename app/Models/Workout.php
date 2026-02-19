<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
