<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Anthropometry extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'patient_id',
        'weights_initial',
        'height',
        'body_fat',
        'body_muscle',
        'physical_activity_level',
        'TMB',
        'GET',
        'lesions',
        'is_active',
    ];
}
