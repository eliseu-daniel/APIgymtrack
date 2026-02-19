<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PatientRegistration extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'patient_id',
        'educator_id',
        'plan_description',
        'start_date',
        'end_date',
        'finalized_at'
    ];
}
