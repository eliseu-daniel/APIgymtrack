<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class DietItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'diet_id',
        'food_id',
        'measure',
        'others',
        'send_notification',
        'is_active',
    ];
}
