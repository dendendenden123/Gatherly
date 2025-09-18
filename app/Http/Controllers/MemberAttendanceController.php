<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\AttendanceService;
use App\Models\Attendance;
use App\Models\Event;

class MemberAttendanceController extends Controller
{
    protected AttendanceService $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }
    public function index(Request $request)
    {
        // Get filter inputs with defaults
        $filters = [
            'time_period' => $request->query('time_period', 'last_30_days'),
            'attendance_status' => $request->query('attendance_status', 'all'),
            'service_type' => $request->query('service_type', 'all'),
        ];

        // Retrieve data using the service
        $userId = Auth::id();
        $eventNames = Event::query()->orderBy('event_name')->pluck('event_name');
        $attendances = $this->attendanceService->getFilteredAttendances($userId, $filters);
        $monthlyAttendancePct = $this->attendanceService->getAttendanceRateLastMonth($userId);

        return view('member.attendance', [
            'eventNames' => $eventNames,
            'attendances' => $attendances,
            'monthlyAttendancePct' => $monthlyAttendancePct,
            'filters' => $filters,
        ]);
    }
}
