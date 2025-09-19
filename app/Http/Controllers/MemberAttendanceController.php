<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\AttendanceService;
use App\Services\EventService;
use App\Models\Attendance;
use App\Models\Event;

class MemberAttendanceController extends Controller
{
    protected AttendanceService $attendanceService;
    protected EventService $eventService;

    public function __construct(AttendanceService $attendanceService, EventService $eventService)
    {
        $this->attendanceService = $attendanceService;
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        $eventIdName = $this->eventService->getEventIdName();
        $filteredAttendancesPaginated = $this->attendanceService->getFilteredAttendancesPaginated($request);

        if ($request->ajax()) {
            $attendancesListView = view("admin.attendance.index-attendance-list", compact('filteredAttendancesPaginated', 'eventIdName'))->render();
            return response()->json([
                'list' => $attendancesListView
            ]);
        }
        return view('member.attendances.index', compact('filteredAttendancesPaginated', "eventIdName"));
    }
    public function showMyAttendance(Request $request)
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

        return view('member.attendances.my-attendance', [
            'eventNames' => $eventNames,
            'attendances' => $attendances,
            'monthlyAttendancePct' => $monthlyAttendancePct,
            'filters' => $filters,
        ]);
    }
}
