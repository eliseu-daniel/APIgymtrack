<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_item_id',
        'comment',
        'send_notification',
    ];

    public function workoutItem(): BelongsTo
    {
        return $this->belongsTo(WorkoutItem::class, 'workout_item_id');
    }
}
