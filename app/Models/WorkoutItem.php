<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkoutItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_id',
        'exercise_id',
        'day_of_week',
        'series',
        'repetitions',
        'weight_load',
        'duration_time',
        'rest_time',
        'send_notification',
        'is_active',
    ];

    public function workout(): BelongsTo
    {
        return $this->belongsTo(Workout::class, 'workout_id');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(WorkoutFeedback::class, 'workout_item_id');
    }
}
