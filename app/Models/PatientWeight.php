<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PatientWeight extends Model
{
    use HasFactory;

    protected $fillable = [
        'weight',
        'patient_id',
        'current_date',
    ];
}
