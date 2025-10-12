<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
        'gender',
        'allergies',
        'is_active',
    ];  
}
