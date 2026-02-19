<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Exercise extends Model
{
    use HasFactory;
    protected $fillable = [
        'muscle_group_id',
        'exercise',
        'link_exercise'
    ];
}
