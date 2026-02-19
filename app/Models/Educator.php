<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Educator extends Model
{
    //
    use HasApiTokens;
    use HasFactory;

    protected $table = 'educators';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'is_active'
    ];

    protected $hidden = [
        'password'
    ];
}
