<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventOccurrence extends Model
{
    /** @use HasFactory<\Database\Factories\EventOccurrenceFactory> */
    use HasFactory;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
