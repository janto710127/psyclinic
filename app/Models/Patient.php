<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

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

    public function timelines(): HasMany
    {
        return $this->hasMany(PatientTimeline::class);
    }
}