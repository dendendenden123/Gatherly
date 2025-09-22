<?php

namespace App\Services;


use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Attendance;
use App\Models\EventOccurrence;

class EventService
{
    public function getAllEvents()
    {
        return Event::with('event_occurrences');
    }

    public function getEventIdName()
    {
        return $this->getAllEvents()->select('id', 'event_name')->get();
    }

    public function getTodaysScheduledEvents()
    {
        return EventOccurrence::with('event')
            ->where('attendance_checked', 0)
            ->where('occurrence_date', [now()->startOfDay(), now()->endOfDay()])
            ->get();
    }

    public function eventAndUserTypeOverlap($request)
    {
        $upcomingEvents = EventOccurrence::with('event')->where(function ($q) {
            $q->where('occurrence_date', '>', today())
                ->orWhere(function ($q2) {
                    $q2->whereDate('occurrence_date', today())
                        ->whereTime('start_time', '>=', now());
                });
        })->where(function ($upcomingEvents) use ($request) {
            $upcomingEvents->whereHas('event', function ($event) use ($request) {
                $event->where('event_type', $request->event_type);
            })->whereBetween('occurrence_date', [$request->start_date, $request->end_date])
                ->where(function ($checkTime) use ($request) {
                    $request->end_time = $request->end_time ?? Carbon::parse($request->start_time)->addHour();

                    $checkTime->whereBetween('start_time', [$request->start_time, $request->end_time])
                        ->orWhereBetween(
                            DB::raw("COALESCE(end_time, DATE_ADD(start_time, INTERVAL 1 HOUR))"),
                            [$request->start_time, $request->end_time]
                        );
                });

        })->get();

        return $upcomingEvents;
    }

    public function getUpcomingEvent()
    {
        return Event::with('event_occurrences')
            ->whereHas('event_occurrences', function ($query) {
                $query->where('occurrence_date', '>=', now()->toDateString())
                    ->where('status', 'pending');
            })
            ->orderByDesc('updated_at')
            ->get();
    }

    public function getEventsAttendedByUser($userId)
    {
        return Attendance::with('event_occurrence.event')
            ->where('user_id', $userId)
            ->where('status', 'present')
            ->get()
            ->map(function ($attendance) {
                return $attendance->event_occurrence->event;
            });
    }

    public function getEventsMissedByUser($userId)
    {
        return Attendance::with('event_occurrence.event')
            ->where('user_id', $userId)
            ->where('status', 'absent')
            ->get()
            ->map(function ($attendance) {
                return $attendance->event_occurrence->event;
            });
    }
}