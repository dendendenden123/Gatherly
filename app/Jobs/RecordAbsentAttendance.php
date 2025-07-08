<?php

namespace App\Jobs;


use App\Models\Event;
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

            logger('code reach job');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Failed to record absent attendance: ' . $e->getMessage());
        }

    }
}
