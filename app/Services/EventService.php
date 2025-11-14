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

    public function eventAndUserTypeOverlap($request, $eventId = null)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time ?? Carbon::parse($request->start_time)->addHour());
        $repeat = $request->repeat; // weekly / monthly / yearly / none

        // 1) Generate the exact falling dates for THIS new event
        $repeatDates = [];

        if ($repeat === 'weekly') {
            $loop = $startDate->copy();
            while ($loop->lte($endDate)) {
                $repeatDates[] = $loop->format('Y-m-d');
                $loop->addWeek();
            }
        } elseif ($repeat === 'monthly') {
            $loop = $startDate->copy();
            while ($loop->lte($endDate)) {
                $repeatDates[] = $loop->format('Y-m-d');
                $loop->addMonth();
            }
        } elseif ($repeat === 'yearly') {
            $loop = $startDate->copy();
            while ($loop->lte($endDate)) {
                $repeatDates[] = $loop->format('Y-m-d');
                $loop->addYear();
            }
        } else {
            // No repeat → only use the single date(s)
            $repeatDates = [$startDate->format('Y-m-d')];
        }

        return EventOccurrence::with('event')
            ->when($eventId, function ($events) use ($eventId) {
                $events->whereNot('event_id', $eventId);
            })
            ->where(function ($q) use ($repeatDates) {

                // 2) Compare only against the actual repeated falling dates
                $q->whereIn(DB::raw('DATE(occurrence_date)'), $repeatDates);

            })
            ->where(function ($q) use ($startTime, $endTime) {

                // 3) Time-based overlap check
                $q->where(function ($query) use ($startTime, $endTime) {
                    $query
                        ->whereTime('start_time', '<=', $endTime)
                        ->whereTime(DB::raw('COALESCE(end_time, DATE_ADD(start_time, INTERVAL 1 HOUR))'), '>=', $startTime);
                });

            })
            ->where('occurrence_date', '>=', today()) // future events only
            ->get();
    }




    public function getUpcomingEvent()
    {
        return EventOccurrence::with(['event', 'attendances'])
            ->where('attendance_checked', '0')
            ->where('status', 'pending')
            ->orderByDesc('updated_at')
            ->get();
    }

    public function getEventsAttendedByUser($userId)
    {
        return EventOccurrence::with(['event', 'attendances'])
            ->whereHas('attendances', function ($attendance) use ($userId) {
                $attendance->where('user_id', $userId)->where('status', 'present');
            })
            ->where('attendance_checked', '1')
            ->get();
    }

    public function getEventsMissedByUser($userId)
    {
        return EventOccurrence::with(['event', 'attendances'])
            ->whereHas('attendances', function ($attendance) use ($userId) {
                $attendance->where('user_id', $userId)->where('status', 'absent');
            })
            ->where('attendance_checked', '1')
            ->orderByDesc('updated_at')
            ->get();
    }
}