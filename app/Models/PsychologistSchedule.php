<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsychologistSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'psychologist_id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_duration',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    public function getDayNameAttribute()
    {
        return match ($this->day_of_week) {
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
            default => '-',
        };
    }

    public function getScheduleAttribute()
    {
        return substr($this->start_time,0,5).' - '.substr($this->end_time,0,5);
    }

    public function getDurationAttribute()
    {
        return $this->slot_duration.' Menit';
    }
    
}