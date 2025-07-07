<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Event;
use App\Models\Attendance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class RecordAbsentAttendance implements ShouldQueue
{
    use Queueable;
    protected $event;

    /**
     * Create a new job instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Skip if event hasn't ended
            // if (Carbon::now('Asia/Manila')->lt(Carbon::parse($this->event->end_time))) {
            //     return;
            // }

            //get all user's Id
            $userIds = User::pluck('id');

            //get all id present in the event
            $present = Attendance::where('event_id', $this->event->id)
                ->pluck('user_id');

            //get all id absent from the event
            $absentees = $userIds->diff($present);

            foreach ($absentees as $userId) {
                Attendance::Create([
                    'event_id' => $this->event->id,
                    'status' => 'absent',
                    'service_date' => now()->format('Y-m-d'),
                    'user_id' => $userId,
                ]);
            }

            \Log::info('Absent attendance recorded successfully.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Failed to record absent attendance: ' . $e->getMessage());
        }

    }
}
