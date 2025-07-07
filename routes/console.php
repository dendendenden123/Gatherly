<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\RecordAbsentAttendance;
use App\Models\Event;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::daily()->at('20:57')->call(function () {
    // Get all events that ended today or just ended
    $events = Event::all();

    foreach ($events as $event) {
        dispatch(new RecordAbsentAttendance($event));
    }
});

Artisan::command('test-job', function () {
    // $event = Event::find(1);
    // dispatch(new RecordAbsentAttendance($event));

    $events = Event::all();

    foreach ($events as $event) {
        dispatch(new RecordAbsentAttendance($event));
    }
});

