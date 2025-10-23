<?php

namespace App\Helpers;

use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceHelper
{

    static function getWorshipDaysCountLastMonth()
    {
        $start = Carbon::now()->subMonth()->startOfMonth();
        $end = Carbon::now()->subMonth()->endOfMonth();

        $thursdays = 0;
        $sundays = 0;

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if ($date->isThursday()) {
                $thursdays++;
            }
            if ($date->isSunday()) {
                $sundays++;
            }
        }
        return $thursdays + $sundays;
    }

}