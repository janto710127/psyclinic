<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPackageUsage extends Model
{
    protected $fillable = [
        'patient_package_id',
        'service_package_detail_id',
        'appointment_id',
        'used_at',
        'quantity',
        'price',
        'notes',
    ];

    protected $casts = [
        'used_at' => 'date',
        'quantity' => 'integer',
        'price' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function patientPackage()
    {
        return $this->belongsTo(PatientPackage::class);
    }

    public function servicePackageDetail()
    {
        return $this->belongsTo(
            ServicePackageDetail::class
        );
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getPriceLabelAttribute()
    {
        if (is_null($this->price)) {
            return '-';
        }

        return 'Rp ' . number_format(
            $this->price,
            0,
            ',',
            '.'
        );
    }

    public function getSubtotalAttribute()
    {
        if (is_null($this->price)) {
            return 0;
        }

        return $this->quantity * $this->price;
    }

    public function getSubtotalLabelAttribute()
    {
        return 'Rp ' . number_format(
            $this->subtotal,
            0,
            ',',
            '.'
        );
    }
}