<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'appointment_no',
        'branch_id',
        'patient_id',
        'psychologist_id',
        'psychologist_schedule_id',
        'service_rate_id',

        'source_type',
        'patient_package_id',
        'service_package_detail_id',
        'duration',

        'appointment_date',
        'appointment_time',
        'status',
        'notes',
        'created_by',
    ];

     protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'duration' => 'integer',
        'status' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    public const STATUS_DRAFT = 1;
    public const STATUS_RESERVED = 2;
    public const STATUS_CHECKED_IN = 3;
    public const STATUS_IN_PROGRESS = 4;
    public const STATUS_COMPLETED = 5;
    public const STATUS_CLOSED = 6;
    public const STATUS_CANCELLED = 7;
    public const STATUS_NO_SHOW = 8;

    public const SOURCE_NORMAL = 1;
    public const SOURCE_PACKAGE = 2;

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_RESERVED => 'Reserved',
            self::STATUS_CHECKED_IN => 'Checked In',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CLOSED => 'Closed',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_NO_SHOW => 'No Show',
            default => 'Tidak Diketahui',
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'secondary',
            self::STATUS_RESERVED => 'primary',
            self::STATUS_CHECKED_IN => 'info',
            self::STATUS_IN_PROGRESS => 'warning',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_CLOSED => 'dark',
            self::STATUS_CANCELLED => 'danger',
            self::STATUS_NO_SHOW => 'warning',
            default => 'secondary',
        };
    }
    

    public function getSourceTypeLabelAttribute()
    {
        return match ($this->source_type) {
            self::SOURCE_NORMAL => 'Tarif Normal',
            self::SOURCE_PACKAGE => 'Patient Package',
            default => 'Tidak Diketahui',
        };
    }

    public function getSourceTypeBadgeAttribute()
    {
        return match ($this->source_type) {
            self::SOURCE_NORMAL => 'primary',
            self::SOURCE_PACKAGE => 'success',
            default => 'secondary',
        };
    }

    public function getEndTimeAttribute()
    {
        if (!$this->appointment_time || !$this->duration) {
            return null;
        }

        return $this->appointment_time
            ->copy()
            ->addMinutes($this->duration);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    public function psychologistSchedule()
    {
        return $this->belongsTo(
            PsychologistSchedule::class,
            'psychologist_schedule_id'
        );
    }

    public function serviceRate()
    {
        return $this->belongsTo(ServiceRate::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function patientPackageUsage()
    {
        return $this->hasOne(PatientPackageUsage::class);
    }

    public function patientPackage()
    {
        return $this->belongsTo(
            PatientPackage::class
        );
    }

    public function servicePackageDetail()
    {
        return $this->belongsTo(
            ServicePackageDetail::class
        );
    }


    
}