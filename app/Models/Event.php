<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsToMany(User::class, 'attendances')
            ->using(Attendance::class)
            ->withPivot([
                'service_date',
                'check_in_time',
                'check_out_time',
                'attendance_method',
                'biometric_data_id',
                'recorded_by',
                'status',
                'notes',
            ])
            ->withTimestamps();
    }
}
