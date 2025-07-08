<?php

namespace App\Console\Commands;

use App;
use Illuminate\Console\Command;
use App\Jobs\RecordAbsentAttendance;
use App\Models\Event;

class EventAbsenteesRecorder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:event-absentees-recorder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Record absent attendees for past events';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /*
        1. get all events that has status "closed"
        2. record absentees

        */
        Dispatch(new RecordAbsentAttendance(Event::find(1)));
    }
}
