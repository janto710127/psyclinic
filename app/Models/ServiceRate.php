<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRate extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'timeline_type_id',

        'psychologist_id',

        'service_code',

        'service_name',

        'duration',

        'price',

        'is_active',

        'notes',

    ];

    protected $casts = [

        'price' => 'decimal:2',

        'is_active' => 'boolean',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */

    public function timelineType()
    {
        return $this->belongsTo(TimelineType::class);
    }

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    // Accessor
    public function getPriceLabelAttribute()
    {
        return 'Rp ' . number_format($this->price,0,',','.');
    }
    public function getDurationLabelAttribute()
    {
        return $this->duration.' Menit';
    }
    public function getStatusLabelAttribute()
    {
        return $this->is_active
            ? 'Aktif'
            : 'Non Aktif';
    }
}