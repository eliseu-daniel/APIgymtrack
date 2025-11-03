<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutFeedback extends Model
{
    protected $fillable = [
        'workout_item_id',
        'comment',
        'send_notification',
    ];
}
