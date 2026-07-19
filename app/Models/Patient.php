<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'patient_number',
        'name',
        'nik',
        'gender',
        'birth_date',
        'phone',
        'email',
        'address',
        'occupation',
        'education',
        'marital_status',
        'emergency_contact_name',
        'emergency_contact_phone',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
}

