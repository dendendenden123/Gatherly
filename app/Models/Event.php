<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventOccurrence;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $guarded = [];

    public function event_occurrences()
    {
        return $this->hasMany(EventOccurrence::class);
    }

    protected static function booted()
    {
        static::created(function ($model) {
            $startDate = \Carbon\Carbon::parse($model->start_date);
            $endDate = \Carbon\Carbon::parse($model->end_date);

            switch ($model->repeat) {
                case 'once':
                    EventOccurrence::create([
                        'event_id' => $model->id,
                        'occurrence_date' => $model->start_date,
                        'start_time' => $model->start_time,
                    ]);
                    break;

                case 'daily':
                    $days = $startDate->diffInDays($endDate);
                    for ($i = 0; $i <= $days; $i++) {
                        EventOccurrence::create([
                            'event_id' => $model->id,
                            'occurrence_date' => $startDate->copy()->addDays($i),
                            'start_time' => $model->start_time,
                        ]);
                    }
                    break;

                case 'weekly':
                    $weeks = $startDate->diffInWeeks($endDate);
                    for ($i = 0; $i <= $weeks; $i++) {
                        EventOccurrence::create([
                            'event_id' => $model->id,
                            'occurrence_date' => $startDate->copy()->addWeeks($i),
                            'start_time' => $model->start_time,
                        ]);
                    }
                    break;

                case 'monthly':
                    $months = $startDate->diffInMonths($endDate);
                    for ($i = 0; $i <= $months; $i++) {
                        EventOccurrence::create([
                            'event_id' => $model->id,
                            'occurrence_date' => $startDate->copy()->addMonths($i),
                            'start_time' => $model->start_time,
                        ]);
                    }
                    break;
                case 'yearly':
                    $years = $startDate->diffInYears($endDate);
                    for ($i = 0; $i <= $years; $i++) {
                        EventOccurrence::create([
                            'event_id' => $model->id,
                            'occurrence_date' => $startDate->copy()->addYears($i),
                            'start_time' => $model->start_time,
                        ]);
                    }
                    break;
            }
        });
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
