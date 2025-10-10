<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Educator extends Model
{
    //
    use HasApiTokens;

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
