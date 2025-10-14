<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'is_active',
        'is_admin',
    ];

    protected $hidden = [
        'password',
    ];
}
