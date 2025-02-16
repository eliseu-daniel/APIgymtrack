<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    public static function getAll(){
        return self::all();
    }
}
