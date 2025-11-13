<?php

namespace App\Models;

use App\Models\EventOccurrence;
use Carbon\Carbon;
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

    protected static function booted()
    {
        static::created(function ($model) {
            $startDate = Carbon::parse($model->start_date);
            $endDate = $model->end_date ? Carbon::parse($model->end_date) : $startDate;

            // Normalize start_time to H:i:s (24-hour) format if not null
            $startTime = $model->start_time;
            if ($startTime) {
                try {
                    // Try to parse as 12-hour or 24-hour, fallback to original if fails
                    $startTime = Carbon::parse($startTime)->format('H:i:s');
                } catch (\Exception $e) {
                    // fallback: set to null if invalid
                    $startTime = null;
                }
            }

            // Normalize end_time to H:i:s format if not null
            $endTime = $model->end_time;
            if ($endTime) {
                try {
                    $endTime = Carbon::parse($endTime)->format('H:i:s');
                } catch (\Exception $e) {
                    $endTime = null;
                }
            }

            switch ($model->repeat) {
                case 'once':
                    EventOccurrence::create([
                        'event_id' => $model->id,
                        'occurrence_date' => $model->start_date,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                    ]);
                    break;

                case 'daily':
                    $days = $startDate->diffInDays($endDate);
                    for ($i = 0; $i <= $days; $i++) {
                        EventOccurrence::create([
                            'event_id' => $model->id,
                            'occurrence_date' => $startDate->copy()->addDays($i),
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                        ]);
                    }
                    break;

                case 'weekly':
                    $weeks = $startDate->diffInWeeks($endDate);
                    for ($i = 0; $i <= $weeks; $i++) {
                        EventOccurrence::create([
                            'event_id' => $model->id,
                            'occurrence_date' => $startDate->copy()->addWeeks($i),
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                        ]);
                    }
                    break;

                case 'monthly':
                    $months = $startDate->diffInMonths($endDate);
                    for ($i = 0; $i <= $months; $i++) {
                        EventOccurrence::create([
                            'event_id' => $model->id,
                            'occurrence_date' => $startDate->copy()->addMonths($i),
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                        ]);
                    }
                    break;
                case 'yearly':
                    $years = $startDate->diffInYears($endDate);
                    for ($i = 0; $i <= $years; $i++) {
                        EventOccurrence::create([
                            'event_id' => $model->id,
                            'occurrence_date' => $startDate->copy()->addYears($i),
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                        ]);
                    }
                    break;
            }
        });
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('M d, Y');
    }

    public function getStartTimeAttribute($value)
    {
        if (!$value)
            return null;
        try {
            // Try full time with seconds
            return Carbon::createFromFormat('H:i:s', $value)->format('h:i A');
        } catch (\Exception $e) {
            try {
                // Try time without seconds
                return Carbon::createFromFormat('H:i', $value)->format('h:i A');
            } catch (\Exception $e) {
                // Fallback: return as is or null
                return $value;
            }
        }
    }

    public function getEndTimeAttribute($value)
    {
        if (!$value)
            return null;
        try {
            // Try full time with seconds
            return Carbon::createFromFormat('H:i:s', $value)->format('h:i A');
        } catch (\Exception $e) {
            try {
                // Try time without seconds
                return Carbon::createFromFormat('H:i', $value)->format('h:i A');
            } catch (\Exception $e) {
                // Fallback: return as is or null
                return $value;
            }
        }
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
