<?php

namespace App\Observers;

use Throwable;
use Carbon\Carbon;
use App\Helpers\AttendanceHelper;
use App\Models\Attendance;
use App\Models\User;

class AttendanceObserver
{
    public function created(Attendance $attendance)
    {
        //
    }
}
