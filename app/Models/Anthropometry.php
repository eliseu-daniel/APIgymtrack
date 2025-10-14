<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anthropometry extends Model
{
    protected $fillable = [
        'weights_initial',
        'height',
        'body_fat',
        'body_muscle',
        'physical_activity_level',
        'TMB',
        'GET',
        'lesions',
    ];
}
