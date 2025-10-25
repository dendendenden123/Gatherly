<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Event;
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
            ->where('attendances.status', 'present')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('attendances.created_at', [$fromDate, $toDate]);
            })
            ->when($fromDate && !$toDate, function ($query) use ($fromDate) {
                $query->where('attendances.created_at', '>=', $fromDate);
            })
            ->when(!$fromDate && $toDate, function ($query) use ($toDate) {
                $query->where('attendances.created_at', '<=', $toDate);
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

    function getWeeklyAttendance($request = null)
    {
        $minDate = $request['from_date'] ?? now()->subYear();
        $maxDate = $request['to_date'] ?? now();

        $start = Carbon::parse($minDate)->startOfMonth();
        $end = Carbon::parse($maxDate)->endOfMonth();

        $weeklyStart = (clone $start);
        $weeklyEnd = (clone $end);
        $weeks = collect();

        $events = DB::table('events')->pluck('event_name');

        while ($weeklyStart <= $weeklyEnd) {
            $weeks->push("Week " . $weeklyStart->isoWeek . " " . $weeklyStart->format('M Y'));
            $weeklyStart->addWeek();
        }

        $weeklyRawData = $this->getAttendanceFilteredReport($request)
            ->join('event_occurrences', 'attendances.event_occurrence_id', '=', 'event_occurrences.id')
            ->join('events', 'event_occurrences.event_id', '=', 'events.id')
            ->select(
                'events.event_name',
                DB::raw('YEAR(attendances.created_at) as year'),
                DB::raw('WEEK(attendances.created_at, 1) as week_number'),
                DB::raw('COUNT(attendances.id) as total_attendance'),
                DB::raw('CONCAT("Week ", WEEK(attendances.created_at, 1), " ", DATE_FORMAT(attendances.created_at, "%b %Y")) as week_label')
            )
            ->groupBy('events.event_name', 'year', 'week_number', 'week_label')
            ->orderBy('year')
            ->orderBy('week_number')
            ->get();

        $weeklySeries = [];

        foreach ($events as $event) {
            $weeklyData = [];
            foreach ($weeks as $week) {
                $attendance = $weeklyRawData->first(function ($row) use ($event, $week) {
                    return $row->event_name === $event && $row->week_label === $week;
                });

                $weeklyData[] = $attendance ? (int) $attendance->total_attendance : 0;
            }

            $weeklySeries[] = [
                'name' => $event,
                'data' => $weeklyData,
            ];
        }

        return [
            'x' => $weeks,
            'series' => $weeklySeries,
        ];
    }


    function getMonthlyAttendance($request = null)
    {
        // Get date range
        $minDate = $request['from_date'] ?? now()->subYear();
        $maxDate = $request['to_date'] ?? now();
        $start = Carbon::parse($minDate)->startOfMonth();
        $end = Carbon::parse($maxDate)->endOfMonth();
        $monthlyStart = (clone $start);
        $monthlyEnd = (clone $end);
        $months = collect();

        //get all events
        $events = DB::table('events')->pluck('event_name');

        // MONTHLY RANGE
        while ($monthlyStart <= $monthlyEnd) {
            $months->push($monthlyStart->format('M Y'));
            $monthlyStart->addMonth();
        }


        // Get attendance counts grouped by event and month
        $monthlyRawData = $this->getAttendanceFilteredReport($request)
            ->join('event_occurrences', 'attendances.event_occurrence_id', '=', 'event_occurrences.id')
            ->join('events', 'event_occurrences.event_id', '=', 'events.id')
            ->select(
                'events.event_name',
                DB::raw('DATE_FORMAT(attendances.created_at, "%b %Y") as month_name'),
                DB::raw('COUNT(attendances.id) as total_attendance')
            )
            ->groupBy('events.event_name', 'month_name')
            ->orderByRaw('MIN(attendances.created_at)')
            ->get();

        $monthlySeries = [];

        // months loops
        foreach ($events as $event) {
            $monthlyData = [];
            foreach ($months as $month) {
                $attendance = $monthlyRawData->first(function ($row) use ($event, $month) {
                    return $row->event_name === $event && $row->month_name === $month;
                });

                $monthlyData[] = $attendance ? (int) $attendance->total_attendance : 0;
            }

            $monthlySeries[] = [
                'name' => $event,
                'data' => $monthlyData,
            ];
        }

        return [
            'x' => $months,
            'series' => $monthlySeries,
        ];

    }

    function getYearlyAttendance($request = null)
    {
        // Get date range
        $minDate = $request['from_date'] ?? now()->subYear();
        $maxDate = $request['to_date'] ?? now();
        $start = Carbon::parse($minDate)->startOfMonth();
        $end = Carbon::parse($maxDate)->endOfMonth();
        $yearlyStart = (clone $start);
        $yearlyEnd = (clone $end);
        $years = collect();

        //get all events
        $events = DB::table('events')->pluck('event_name');

        // MONTHLY RANGE
        while ($yearlyStart <= $yearlyEnd) {
            $years->push($yearlyStart->format('Y'));
            $yearlyStart->addYear();
        }


        // Get attendance counts grouped by event and month
        $yearlyRawData = $this->getAttendanceFilteredReport($request)
            ->join('event_occurrences', 'attendances.event_occurrence_id', '=', 'event_occurrences.id')
            ->join('events', 'event_occurrences.event_id', '=', 'events.id')
            ->select(
                'events.event_name',
                DB::raw('YEAR(attendances.created_at) as year_name'),
                DB::raw('COUNT(attendances.id) as total_attendance')
            )
            ->groupBy('events.event_name', 'year_name')
            ->orderBy('year_name')
            ->get();


        $yearlySeries = [];

        // years loops
        foreach ($events as $event) {
            $yearlyData = [];
            foreach ($years as $year) {
                $attendance = $yearlyRawData->first(function ($row) use ($event, $year) {
                    return $row->event_name === $event && $row->year_name == $year;
                });

                $yearlyData[] = $attendance ? (int) $attendance->total_attendance : 0;
            }

            $yearlySeries[] = [
                'name' => $event,
                'data' => $yearlyData,
            ];
        }

        return [
            'x' => $years,
            'series' => $yearlySeries,
        ];

    }

    function getAttendanceBars()
    {
        $bars = [
            'attendance' => [],
            'data' => [],
        ];

        Event::with([
            'event_occurrences.attendances' => function ($attendance) {
                $attendance->where('status', 'present');
            }
        ])
            ->get()
            ->map(function ($query) use (&$bars) {
                $bars['attendance'][] = $query->event_name;

                // Count total present attendances for this event
                $total = $query->event_occurrences->sum(function ($occurrence) {
                    return $occurrence->attendances->count();
                });

                $bars['data'][] = $total;
            });

        return $bars;

    }
}