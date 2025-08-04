<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $guarded = [];

    public function event_occurrences()
    {
        return $this->hasMany(EventOccurrence::class);
    }

    public function scopeFilter($query, $filters)
    {
        $start = $filters['start_date'] ?? now()->subCentury();
        $end = $filters['end_date'] ?? now()->addCentury();
        $eventId = $filters['id'] ?? null;
        $eventName = $filters['event_name'] ?? null;
        $eventType = $filters['event_type'] ?? null;
        $repeat = $filters['repeat'] ?? null;
        $status = $filters['status'] ?? null;

        return $query->with('event_occurrences')
            ->whereBetween('updated_at', [$start, $end])
            ->when($eventId, function ($query) use ($eventId) {
                $query->where('id', $eventId);
            })
            ->when($eventName, function ($query) use ($eventName) {
                $query->where('event_name', 'like', '%' . $eventName . '%');
            })

            ->when($eventType, function ($query) use ($eventType) {
                $query->where('event_type', $eventType);
            })
            ->when($repeat, function ($query) use ($repeat) {
                $query->where('repeat', $repeat);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            });
    }

    public static function getEventSummary()
    {
        return self::with('event_occurrences')->select('event_name', 'repeat', 'start_date', 'end_date')->get();
    }
}
