<?php

namespace App\Services;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    function getAttendanceFilteredReport($request = null)
    {
        $fromDate = $request['from_date'] ?? null;
        $toDate = $request['to_date'] ?? null;
        $eventType = $request['event_type'] ?? null;
        $ageGroup = $request['age_group'] ?? null;

        $attendancefilteredReport = Attendance::with('event_occurrence.event', 'user')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            })
            ->when($fromDate && !$toDate, function ($query) use ($fromDate) {
                $query->where('created_at', '>=', $fromDate);
            })
            ->when(!$fromDate && $toDate, function ($query) use ($toDate) {
                $query->where('created_at', '<=', $toDate);
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

    function getReportData($request = null)
    {
        //get date range
        $minDate = $request['from_date'] ?? now()->subYear();
        $maxDate = $request['to_date'] ?? now();
        $start = Carbon::parse($minDate)->startOfMonth();
        $end = Carbon::parse($maxDate)->startOfMonth();

        $months = collect();
        while ($start <= $end) {
            $months->push($start->format('M Y'));
            $start->addMonth();
        }

        // Get attendance counts grouped by event and month
        $rawData = DB::table('events')
            ->leftJoin('event_occurrences', 'events.id', '=', 'event_occurrences.event_id')
            ->leftJoin('attendances', 'event_occurrences.id', '=', 'attendances.event_occurrence_id')
            ->select(
                'events.event_name',
                DB::raw('DATE_FORMAT(attendances.created_at, "%b %Y") as month_name'),
                DB::raw('COUNT(attendances.id) as total_attendance')
            )
            ->groupBy('events.event_name', 'month_name')
            ->orderByRaw('MIN(attendances.created_at)')
            ->get();

        //get all events
        $events = DB::table('events')->pluck('event_name');


        $result = [];
        foreach ($events as $event) {
            $monthlyData = [];

            foreach ($months as $month) {
                $attendance = $rawData->first(function ($row) use ($event, $month) {
                    return $row->event_name === $event && $row->month_name === $month;
                });

                $monthlyData[] = $attendance ? (int) $attendance->total_attendance : 0;
            }

            $result[] = [
                'name' => $event,
                'data' => $monthlyData,
            ];
        }


        return [
            'x' => $months,
            'series' => $result,
        ];

    }
}