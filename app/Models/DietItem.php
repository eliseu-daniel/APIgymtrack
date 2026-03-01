<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class DietItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'diet_id',
        'food_id',
        'meals_id',
        'meal_time',
        'quantity',
        'measure',
        'others',
        'send_notification',
        'is_active',
    ];
}
