<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DietFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'diet_id',
        'comment',
        'send_notification',
    ];

    public function diet(): BelongsTo
    {
        return $this->belongsTo(Diet::class, 'diet_id');
    }
}
