<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientWeight extends Model
{
    protected $fillable = [
        'weight',
        'id_patient',
        'current_date',
    ];
}
