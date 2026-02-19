<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Administrator extends Model
{
    use HasFactory;
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
