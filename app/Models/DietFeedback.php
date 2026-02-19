<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DietFeedback extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'diet_id',
        'comment',
        'send_notification',
    ];
}
