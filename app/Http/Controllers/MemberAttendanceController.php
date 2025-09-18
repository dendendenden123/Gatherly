<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Event;

class MemberAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $eventNames = Event::query()->orderBy('event_name')->pluck('event_name');
        $loggedUserId = Auth::id();

        // Selected filters from query string (GET)
        $timePeriod = $request->query('time_period', 'last_30_days'); // last_30_days|last_3_months|last_6_months|this_year|all_time
        $attendanceStatus = $request->query('attendance_status', 'all'); // all|present|absent
        $serviceType = $request->query('service_type', 'all'); // all|<free-text>

        // Determine date range based on time period
        $from = null;
        $to = now();
        switch ($timePeriod) {
            case 'last_3_months':
                $from = now()->subMonthsNoOverflow(3);
                break;
            case 'last_6_months':
                $from = now()->subMonthsNoOverflow(6);
                break;
            case 'this_year':
                $from = now()->startOfYear();
                break;
            case 'all_time':
                $from = null; // no lower bound
                break;
            case 'last_30_days':
            default:
                $from = now()->subDays(30);
                break;
        }

        $query = Attendance::query()
            ->with(['event_occurrence.event'])
            ->where('user_id', $loggedUserId);

        if ($from) {
            // Use updated_at for simplicity; adjust to occurrence_date if needed
            $query->whereBetween('updated_at', [$from, $to]);
        }

        if (in_array($attendanceStatus, ['present', 'absent'])) {
            $query->where('status', $attendanceStatus);
        }

        if ($serviceType && $serviceType !== 'all') {
            // Filter by event name containing the selected service type text
            $query->whereHas('event_occurrence.event', function ($q) use ($serviceType) {
                $q->where('event_name', 'like', "%{$serviceType}%");
            });
        }

        $attendances = $query
            ->orderByDesc('updated_at')
            ->paginate(10)
            ->appends($request->query());

        // Monthly attendance summary for the logged-in user (current month vs previous month)
        $now = now();
        $currentStart = $now->copy()->startOfMonth();
        $currentEnd = $now->copy()->endOfMonth();
        $previousStart = $currentStart->copy()->subMonthNoOverflow()->startOfMonth();
        $previousEnd = $currentStart->copy()->subMonthNoOverflow()->endOfMonth();

        $currentTotal = Attendance::where('user_id', $loggedUserId)
            ->whereBetween('updated_at', [$currentStart, $currentEnd])
            ->count();
        $currentPresent = Attendance::where('user_id', $loggedUserId)
            ->where('status', 'present')
            ->whereBetween('updated_at', [$currentStart, $currentEnd])
            ->count();
        $currentPct = $currentTotal > 0 ? round(($currentPresent / $currentTotal) * 100) : 0;

        $previousTotal = Attendance::where('user_id', $loggedUserId)
            ->whereBetween('updated_at', [$previousStart, $previousEnd])
            ->count();
        $previousPresent = Attendance::where('user_id', $loggedUserId)
            ->where('status', 'present')
            ->whereBetween('updated_at', [$previousStart, $previousEnd])
            ->count();
        $previousPct = $previousTotal > 0 ? round(($previousPresent / $previousTotal) * 100) : 0;

        $monthlyAttendancePct = $currentPct; // integer percent 0..100
        $monthlyAttendanceDelta = $currentPct - $previousPct; // can be negative/zero/positive

        return view('member.attendance', [
            'eventNames' => $eventNames,
            'attendances' => $attendances,
            'monthlyAttendancePct' => $monthlyAttendancePct,
            'monthlyAttendanceDelta' => $monthlyAttendanceDelta,
            'filters' => [
                'time_period' => $timePeriod,
                'attendance_status' => $attendanceStatus,
                'service_type' => $serviceType,
            ],
        ]);
    }
}
