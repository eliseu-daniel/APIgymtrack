<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DietItem extends Model
{
    protected $fillable = [
        'diet_id',
        'food_id',
        'measure',
        'others',
        'send_notification',
        'is_active',
    ];
}
