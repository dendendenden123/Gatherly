<?php

use App\Jobs\UpdateMemberStatusJob;
use App\Services\UserService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\CheckEventOccurrence;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new UpdateMemberStatusJob(new UserService))->monthlyOn(1, '00:00');

