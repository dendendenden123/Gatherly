<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EventOccurrence;
use App\Jobs\RecordAbsentAttendance;

class CheckEventOccurrence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-event-occurrence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $event_occurrences = EventOccurrence::whereDate('occurrence_date', today()->format('Y-m-d'))
                ->where('status', 'ended')
                ->where('attendance_checked', false)
                ->get();

            if ($event_occurrences->isEmpty()) {
                return;
            }

            dispatch(job: new RecordAbsentAttendance($event_occurrences));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
