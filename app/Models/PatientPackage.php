<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientPackage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_package_no',
        'patient_id',
        'service_package_id',
        'price',
        'purchased_at',
        'started_at',
        'expired_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'purchased_at' => 'date',
        'started_at' => 'date',
        'expired_at' => 'date',
        'status' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    public const STATUS_ACTIVE = 1;
    public const STATUS_COMPLETED = 2;
    public const STATUS_EXPIRED = 3;
    public const STATUS_CANCELLED = 4;

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function servicePackage()
    {
        return $this->belongsTo(ServicePackage::class);
    }

    public function usages()
    {
        return $this->hasMany(PatientPackageUsage::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getPriceLabelAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_EXPIRED => 'Kadaluarsa',
            self::STATUS_CANCELLED => 'Dibatalkan',
            default => 'Tidak Diketahui',
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'success',
            self::STATUS_COMPLETED => 'primary',
            self::STATUS_EXPIRED => 'secondary',
            self::STATUS_CANCELLED => 'danger',
            default => 'secondary',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Usage Helpers
    |--------------------------------------------------------------------------
    */

    public function getUsedQuantityAttribute()
    {
        return $this->usages->sum('quantity');
    }

    public function getRemainingQuantityAttribute()
    {
        $totalQuantity = $this->servicePackage
            ->details
            ->sum('quantity');

        return max(0, $totalQuantity - $this->used_quantity);
    }
}