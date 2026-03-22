<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diet extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
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

    public function feedbacks(): HasMany
    {
        return $this->hasMany(DietFeedback::class, 'diet_id');
    }
}
