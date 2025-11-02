<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventOccurrence extends Model
{
    /** @use HasFactory<\Database\Factories\EventOccurrenceFactory> */
    use HasFactory;

    protected $guarded = [];
    public $table = 'event_occurrences';

    protected $casts = [
        'occurrence_date' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }


    public function getStartTimeFormattedAttribute()
    {
        if (!$this->start_time) {
            return 'NA';
        }
        return Carbon::createFromFormat('H:i:s', $this->start_time)->format('h:i A');
    }
}


