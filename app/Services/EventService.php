<?php

namespace App\Services;

use App\Models\Event;
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


    //====================================
    //===Fetch all events scheduled for today that haven't been marked as attended yet
    //===================================
    public function getTodaysScheduledEvents()
    {
        return EventOccurrence::with('event')
            ->where('attendance_checked', 0)
            ->where('occurrence_date', [now()->startOfDay(), now()->endOfDay()])
            ->get();
    }

}