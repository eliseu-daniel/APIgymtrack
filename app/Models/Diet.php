<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    protected $fillable = [
        'patient_id',
        'meals_id',
        'meal_time',
        'diet_type',
        'goal_weight',
        'objective',
        'calories',
        'proteins',
        'carbohydrates',
        'fats',
        'start_date',
        'end_date',
        'finalized_at',
    ];
}
