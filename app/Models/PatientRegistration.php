<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientRegistration extends Model
{
    protected $fillable = [
        'patient_id',
        'educator_id',
        'plan_description',
        'start_date',
        'end_date',
        'finalized_at'
    ];
}
