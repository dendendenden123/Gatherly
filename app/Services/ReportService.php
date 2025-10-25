<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    function getAttendanceFilteredReport($request = null, $status = null)
    {
        $fromDate = $request['from_date'] ?? null;
        $toDate = $request['to_date'] ?? null;
        $eventType = $request['event_type'] ?? null;
        $ageGroup = $request['age_group'] ?? null;

        $attendancefilteredReport = Attendance::with('event_occurrence.event', 'user')
            ->when($status == 'absent', function ($attedances) {
                $attedances->where('attendances.status', 'absent');
            })
            ->when($status == 'present', function ($attedances) {
                $attedances->where('attendances.status', 'present');
            })
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

        $weeklyRawData = $this->getAttendanceFilteredReport($request, 'present')
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
        $monthlyRawData = $this->getAttendanceFilteredReport($request, 'present')
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
        $yearlyRawData = $this->getAttendanceFilteredReport($request, 'present')
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

    function getAttendanceBars($request)
    {
        $bars = [
            'attendance' => [],
            'data' => [],
        ];
        $events = Event::query()->select('id', 'event_name')->get();

        $events->each(function ($event) use (&$bars, $request) {
            $bars['attendance'][] = $event->event_name;
            $eventId = $event->id;
            $bars['data'][] = $this->getAttendanceFilteredReport($request, 'present')
                ->whereHas('event_occurrence', function ($eventOccurrence) use ($eventId) {
                    $eventOccurrence->where('event_id', $eventId);
                })->count();

        });

        return $bars;
    }

    function getWeeklyEngagement($request)
    {
        $minDate = $request['from_date'] ?? now()->subYear();
        $maxDate = $request['to_date'] ?? now();

        $start = Carbon::parse($minDate)->startOfMonth();
        $end = Carbon::parse($maxDate)->endOfMonth();

        $weeklyStart = (clone $start);
        $weeklyEnd = (clone $end);
        $weeks = collect();

        // Get all events
        $events = DB::table('events')->pluck('event_name');

        // Build week labels
        while ($weeklyStart <= $weeklyEnd) {
            $weeks->push("Week " . $weeklyStart->isoWeek . " " . $weeklyStart->format('M Y'));
            $weeklyStart->addWeek();
        }

        // --- 1️⃣ Get total attendances (all statuses)
        $totalWeekly = $this->getAttendanceFilteredReport($request)
            ->join('event_occurrences', 'attendances.event_occurrence_id', '=', 'event_occurrences.id')
            ->join('events', 'event_occurrences.event_id', '=', 'events.id')
            ->select(
                'events.event_name',
                DB::raw('YEAR(attendances.created_at) as year'),
                DB::raw('WEEK(attendances.created_at, 1) as week_number'),
                DB::raw('COUNT(attendances.id) as total_count'),
                DB::raw('CONCAT("Week ", WEEK(attendances.created_at, 1), " ", DATE_FORMAT(attendances.created_at, "%b %Y")) as week_label')
            )
            ->groupBy('events.event_name', 'year', 'week_number', 'week_label')
            ->get();

        // --- 2️⃣ Get present attendances only
        $presentWeekly = $this->getAttendanceFilteredReport($request, 'present')
            ->join('event_occurrences', 'attendances.event_occurrence_id', '=', 'event_occurrences.id')
            ->join('events', 'event_occurrences.event_id', '=', 'events.id')
            ->select(
                'events.event_name',
                DB::raw('YEAR(attendances.created_at) as year'),
                DB::raw('WEEK(attendances.created_at, 1) as week_number'),
                DB::raw('COUNT(attendances.id) as present_count'),
                DB::raw('CONCAT("Week ", WEEK(attendances.created_at, 1), " ", DATE_FORMAT(attendances.created_at, "%b %Y")) as week_label')
            )
            ->groupBy('events.event_name', 'year', 'week_number', 'week_label')
            ->get();

        // --- 3️⃣ Compute engagement per week (present / total * 100)
        $weeklySeries = [];

        foreach ($events as $event) {
            $weeklyData = [];

            foreach ($weeks as $week) {
                $total = $totalWeekly->first(fn($row) => $row->event_name === $event && $row->week_label === $week);
                $present = $presentWeekly->first(fn($row) => $row->event_name === $event && $row->week_label === $week);

                $totalCount = $total ? (int) $total->total_count : 0;
                $presentCount = $present ? (int) $present->present_count : 0;

                // Compute engagement percentage
                $engagement = $totalCount > 0 ? round(($presentCount / $totalCount) * 100, 2) : 0;

                $weeklyData[] = $engagement;
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

    function getMonthlyEngagement($request)
    {
        $minDate = $request['from_date'] ?? now()->subYear();
        $maxDate = $request['to_date'] ?? now();

        $start = Carbon::parse($minDate)->startOfMonth();
        $end = Carbon::parse($maxDate)->endOfMonth();

        $monthStart = (clone $start);
        $months = collect();

        // Get all events
        $events = DB::table('events')->pluck('event_name');

        // Build month labels
        while ($monthStart <= $end) {
            $months->push($monthStart->format('M Y'));
            $monthStart->addMonth();
        }

        // --- 1️⃣ Get total attendances (all statuses)
        $totalMonthly = $this->getAttendanceFilteredReport($request)
            ->join('event_occurrences', 'attendances.event_occurrence_id', '=', 'event_occurrences.id')
            ->join('events', 'event_occurrences.event_id', '=', 'events.id')
            ->select(
                'events.event_name',
                DB::raw('YEAR(attendances.created_at) as year'),
                DB::raw('MONTH(attendances.created_at) as month_number'),
                DB::raw('COUNT(attendances.id) as total_count'),
                DB::raw('DATE_FORMAT(attendances.created_at, "%b %Y") as month_label')
            )
            ->groupBy('events.event_name', 'year', 'month_number', 'month_label')
            ->get();

        // --- 2️⃣ Get present attendances only
        $presentMonthly = $this->getAttendanceFilteredReport($request, 'present')
            ->join('event_occurrences', 'attendances.event_occurrence_id', '=', 'event_occurrences.id')
            ->join('events', 'event_occurrences.event_id', '=', 'events.id')
            ->select(
                'events.event_name',
                DB::raw('YEAR(attendances.created_at) as year'),
                DB::raw('MONTH(attendances.created_at) as month_number'),
                DB::raw('COUNT(attendances.id) as present_count'),
                DB::raw('DATE_FORMAT(attendances.created_at, "%b %Y") as month_label')
            )
            ->groupBy('events.event_name', 'year', 'month_number', 'month_label')
            ->get();

        // --- 3️⃣ Compute engagement per month (present / total * 100)
        $monthlySeries = [];

        foreach ($events as $event) {
            $monthlyData = [];

            foreach ($months as $month) {
                $total = $totalMonthly->first(fn($row) => $row->event_name === $event && $row->month_label === $month);
                $present = $presentMonthly->first(fn($row) => $row->event_name === $event && $row->month_label === $month);

                $totalCount = $total ? (int) $total->total_count : 0;
                $presentCount = $present ? (int) $present->present_count : 0;

                // Compute engagement percentage
                $engagement = $totalCount > 0 ? round(($presentCount / $totalCount) * 100, 2) : 0;

                $monthlyData[] = $engagement;
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
    function getYearlyEngagement($request)
    {
        $minDate = $request['from_date'] ?? now()->subYears(5);
        $maxDate = $request['to_date'] ?? now();

        $start = Carbon::parse($minDate)->startOfYear();
        $end = Carbon::parse($maxDate)->endOfYear();

        $yearStart = (clone $start);
        $years = collect();

        // Get all events
        $events = DB::table('events')->pluck('event_name');

        // Build year labels
        while ($yearStart <= $end) {
            $years->push($yearStart->format('Y'));
            $yearStart->addYear();
        }

        // --- 1️⃣ Get total attendances (all statuses)
        $totalYearly = $this->getAttendanceFilteredReport($request)
            ->join('event_occurrences', 'attendances.event_occurrence_id', '=', 'event_occurrences.id')
            ->join('events', 'event_occurrences.event_id', '=', 'events.id')
            ->select(
                'events.event_name',
                DB::raw('YEAR(attendances.created_at) as year_number'),
                DB::raw('COUNT(attendances.id) as total_count')
            )
            ->groupBy('events.event_name', 'year_number')
            ->get();

        // --- 2️⃣ Get present attendances only
        $presentYearly = $this->getAttendanceFilteredReport($request, 'present')
            ->join('event_occurrences', 'attendances.event_occurrence_id', '=', 'event_occurrences.id')
            ->join('events', 'event_occurrences.event_id', '=', 'events.id')
            ->select(
                'events.event_name',
                DB::raw('YEAR(attendances.created_at) as year_number'),
                DB::raw('COUNT(attendances.id) as present_count')
            )
            ->groupBy('events.event_name', 'year_number')
            ->get();

        // --- 3️⃣ Compute engagement per year (present / total * 100)
        $yearlySeries = [];

        foreach ($events as $event) {
            $yearlyData = [];

            foreach ($years as $year) {
                $total = $totalYearly->first(fn($row) => $row->event_name === $event && $row->year_number == $year);
                $present = $presentYearly->first(fn($row) => $row->event_name === $event && $row->year_number == $year);

                $totalCount = $total ? (int) $total->total_count : 0;
                $presentCount = $present ? (int) $present->present_count : 0;

                // Compute engagement percentage
                $engagement = $totalCount > 0 ? round(($presentCount / $totalCount) * 100, 2) : 0;

                $yearlyData[] = $engagement;
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

    function getAttendanceDetails($request)
    {
        $attendanceDetail = $this->getAttendanceFilteredReport($request)
            ->join('event_occurrences', 'attendances.event_occurrence_id', '=', 'event_occurrences.id')
            ->join('events', 'event_occurrences.event_id', '=', 'events.id')
            ->select(
                DB::raw('DATE_FORMAT(events.created_at, "%M %e, %Y") as date'),
                'events.event_name as name',
                'events.event_type as type',
                DB::raw('COUNT(*) as total_attendance'),
                DB::raw('SUM(CASE WHEN attendances.status = "present" THEN 1 ELSE 0 END) as total_present'),
                DB::raw('SUM(CASE WHEN attendances.status = "absent" THEN 1 ELSE 0 END) as total_absent')
            )
            ->groupBy('events.event_name', 'events.event_type', 'events.created_at')
            ->get()
            ->map(function ($attendance) {
                return [
                    'name' => $attendance->name,
                    'date' => $attendance->date,
                    'type' => $attendance->type,
                    'attendance' => $attendance->total_present,
                    'engagement' => number_format(($attendance->total_present / $attendance->total_attendance) * 100, 2) . '%'
                ];
            });
        return $attendanceDetail;
    }

    function getEngagementDetails($request)
    {
        $engagementDetail = $this->getAttendanceFilteredReport($request)
            ->join('users', 'attendances.user_id', '=', 'users.id')
            ->join('event_occurrences', 'attendances.event_occurrence_id', '=', 'event_occurrences.id')
            ->join('events', 'event_occurrences.event_id', '=', 'events.id')
            ->select(
                DB::raw('DATE_FORMAT(events.created_at, "%M %e, %Y") as date'),
                'users.first_name as first',
                'events.event_type as type',
                DB::raw('COUNT(*) as total_attendance'),
                DB::raw('SUM(CASE WHEN attendances.status = "present" THEN 1 ELSE 0 END) as total_present'),
                DB::raw('SUM(CASE WHEN attendances.status = "absent" THEN 1 ELSE 0 END) as total_absent')
            )
            ->groupBy('events.event_name', 'events.event_type', 'events.created_at')
            ->get()
            ->map(function ($attendance) {
                return [
                    'name' => $attendance->name,
                    'date' => $attendance->date,
                    'type' => $attendance->type,
                    'attendance' => $attendance->total_present,
                    'engagement' => number_format(($attendance->total_present / $attendance->total_attendance) * 100, 2) . '%'
                ];
            });
        return $engagementDetail;

        //  name: `Member ${i + 1}`,
        //         date: "Nov 2024",
        //         type: "Engagement",
        //         attendance: `${Math.floor(Math.random() * 12)}/14`,
        //         capacity: "-",
        //         firstTimers: "-",
        //         engagement: `${60 + (i % 20)}%`,
    }
}