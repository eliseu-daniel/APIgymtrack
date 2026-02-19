<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class WorkoutFeedback extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'workout_item_id',
        'comment',
        'send_notification',
    ];
}
