<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Attendance;
use App\Models\User;
use App\Models\EventOccurrence;
use App\Models\Event;


class RecordAbsentAttendance implements ShouldQueue
{
    use Queueable;

    private $event_occurrences;

    /**
     * Create a new job instance.
     */
    public function __construct($event_occurrences)
    {
        $this->event_occurrences = $event_occurrences;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //get all users 
        $allUsersId = User::pluck('id');

        //Record all absent attendance
        foreach ($this->event_occurrences as $eventOccurrence) {

            $event = Event::find($eventOccurrence)->firstOrFail();
            $presentUserId = Attendance::where("occurrence_id", $eventOccurrence->id)->pluck('user_id');
            $absentUsersId = $allUsersId->diff($presentUserId);

            foreach ($absentUsersId as $userId) {
                Attendance::updateOrCreate([
                    "user_id" => $userId,
                    "occurrence_id" => $eventOccurrence->id,
                ], [
                    "service_date" => now()->format('Y-m-d'),
                    "status" => "absent"
                ]);
            }

            //update the event_occurence mark as recorded
            $eventOccurrence->update(["attendance_checked" => 1]);

            \Log::info('Successfully recorded absent attendance for event', [
                "Event id" => $eventOccurrence->event_id,
                "Event Occurrence id" => $eventOccurrence->id
            ]);

            $this->createNewEventOccurence(Event::where("id", $eventOccurrence->event_id)->firstOrFail());
        }
    }

    private function createNewEventOccurence($event)
    {
        if ($event->repeat == "once" || $event->status == "completed" || $event->end_date <= now()->format('Y-m-d')) {
            return;
        }

        switch ($event->repeat) {
            case "daily";
                $nextOccurence = now()->addDay();
                break;
            case "weekly":
                $nextOccurence = now()->addWeek();
                break;
            case "monthly":
                $nextOccurence = now()->addMonth();
                break;
            case "yearly":
                $nextOccurence = now()->addYear();
                break;
        }

        if ($nextOccurence > $event->end_date) {
            return;
        }

        $newEventOccurrence = EventOccurrence::Create([
            'event_id' => $event->id,
            'occurrence_date' => $nextOccurence->format('Y-m-d'),
            'status' => 'pending'
        ]);

        \Log::info("Successfully Created new occurence for the event", [
            "event id" => $event->id,
            "event_occurrence_id" => $newEventOccurrence->id,
        ]);
    }
}
