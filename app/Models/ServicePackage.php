<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePackage extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'package_code',

        'package_name',

        'price',

        'validity_days',

        'is_active',

        'notes',

    ];

    protected $casts = [

        'price' => 'decimal:2',

        'validity_days' => 'integer',

        'is_active' => 'boolean',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */

    public function details()
    {
        return $this->hasMany(ServicePackageDetail::class);
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

    public function getValidityLabelAttribute()
    {
        if (is_null($this->validity_days)) {
            return 'Tidak terbatas';
        }

        return $this->validity_days . ' Hari';
    }

    public function getStatusLabelAttribute()
    {
        return $this->is_active
            ? 'Aktif'
            : 'Non Aktif';
    }
}