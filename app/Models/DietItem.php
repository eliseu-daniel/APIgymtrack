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

    public function diet()
    {
        return $this->belongsTo(Diet::class, 'diet_id');
    }

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meals_id');
    }
}
