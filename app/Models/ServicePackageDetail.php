<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePackageDetail extends Model
{
    protected $fillable = [

        'service_package_id',

        'service_rate_id',

        'quantity',

        'price',

        'notes',

    ];

    protected $casts = [

        'quantity' => 'integer',

        'price' => 'decimal:2',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */

    public function servicePackage()
    {
        return $this->belongsTo(ServicePackage::class);
    }

    public function serviceRate()
    {
        return $this->belongsTo(ServiceRate::class);
    }

    public function usages()
    {
        return $this->hasMany(PatientPackageUsage::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    public function getPriceLabelAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    public function getSubtotalLabelAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}