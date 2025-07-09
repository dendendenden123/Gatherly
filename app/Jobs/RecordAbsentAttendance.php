<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Attendance;

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



        foreach ($this->event_occurrences as $event_occurrence) {
            $event_occurrence->update(['attendance_checked' => true]);
            $event_occurrence->save();
        }
    }
}
