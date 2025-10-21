<?php

namespace App\Services;

use App\Models\Attendance;
use Carbon\Carbon;

class ReportService
{
    function getAttendanceFilteredReport($request = null)
    {
        $dateRange = $request['date_range'] ?? null;
        $eventType = $request['event_type'] ?? null;
        $ageGroup = $request['age_group'] ?? null;

        $attendancefilteredReport = Attendance::with('event_occurrence.event', 'user')
            ->when($dateRange, function ($query) use ($dateRange) {
                //code here
                switch ($dateRange) {
                    case '7days':
                        $query->where('created_at', '>=', now()->subDays(7));
                        break;

                    case '30days':
                        $query->where('created_at', '>=', now()->subDays(30));
                        break;

                    case '3months':
                        $query->where('created_at', '>=', now()->subMonths(3));
                        break;

                    case '6months':
                        $query->where('created_at', '>=', now()->subMonths(6));
                        break;

                    case 'yeartodate':
                        $query->where('created_at', '>=', now()->startOfYear());
                        break;

                    default:
                        // Optional: no filtering (shows all records)
                        break;
                }
            })
            ->when($eventType, function ($query) use ($eventType) {
                $query->whereHas('event_occurrence.event', function ($event) use ($eventType) {
                    $event->where('event_type', $eventType);
                });
            })
            ->when($ageGroup, function ($query) use ($ageGroup) {
                $query->whereHas('user', function ($userQuery) use ($ageGroup) {
                    $today = Carbon::today();

                    switch ($ageGroup) {
                        case 'binhi': // below 18 years old
                            $cutoffDate = $today->copy()->subYears(18);
                            $userQuery->where('birthdate', '>', $cutoffDate);
                            break;

                        case 'kadiwa': // 18 or older and not married
                            $cutoffDate = $today->copy()->subYears(18);
                            $userQuery->where('birthdate', '<=', $cutoffDate)
                                ->where('marital_status', '!=', 'married');
                            break;

                        case 'bukload': // married
                            $userQuery->where('marital_status', 'married');
                            break;

                        default:
                            // no filter
                            break;
                    }
                });
            });


        return $attendancefilteredReport;
    }
}