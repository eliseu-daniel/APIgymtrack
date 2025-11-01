<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DietFeedback extends Model
{
    protected $fillable = [
        'diet_id',
        'comment',
        'send_notification',
    ];
}
