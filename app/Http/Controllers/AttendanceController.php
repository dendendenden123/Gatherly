<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAttendanceRequest;
use App\Services\AttendanceService;
use App\Services\EventService;
use App\Services\UserService;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Event;


class AttendanceController extends Controller
{
    protected AttendanceService $attendanceService;
    protected EventService $eventService;
    protected UserService $userService;
    public function __construct(AttendanceService $attendanceService, EventService $eventService, UserService $userService)
    {
        $this->eventService = $eventService;
        $this->attendanceService = $attendanceService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $eventIdName = $this->eventService->getEventIdName();
        $attendances = $this->attendanceService->getFilteredAttendancesPaginated($request);

        // Handle AJAX request
        if ($request->ajax()) {
            $listView = view(
                "admin.attendance.index-attendance-list",
                compact('attendances', 'eventIdName')
            )->render();

            return response()->json(['list' => $listView]);
        }

        // Choose view based on role
        $view = in_array('Minister', $this->userService->getUsersRoles(Auth::id()))
            ? 'admin.attendance.index'
            : 'member.attendances.index';

        return view($view, compact('attendances', 'eventIdName'));
    }


    public function show(Request $request, $id = null)
    {

        $user = User::find($id);
        $eventIdName = $this->eventService->getEventIdName();
        $totalAttendanceCount = $this->attendanceService->countUserAttendances($id);
        $attendanceGrowthRateLastMonth = $this->attendanceService->getAttendanceGrowthRateLastMonth($id);
        $attendanceRateLastMonth = $this->attendanceService->getAttendanceRateLastMonth($id);
        $attendances = $this->attendanceService->getFilteredAttendancesPaginated($request, $id);
        $aggregatedChartDataForAttended = Attendance::getAggregatedChartData([...$request->all(), 'status' => 'present', 'user_id' => $id]);
        $aggregatedChartDataForAbsent = Attendance::getAggregatedChartData([...$request->all(), 'status' => 'absent', 'user_id' => $id]);

        if ($request->ajax()) {
            $chartView = view('admin.attendance.show-attendance-chart', compact('aggregatedChartDataForAttended', 'aggregatedChartDataForAbsent'))->render();
            $attendanceListView = view('admin.attendance.show-attendance-list', compact('attendances'))->render();

            return response()->json([
                'chart' => $chartView,
                'list' => $attendanceListView,
            ]);
        }

        return view('admin.attendance.show', compact(
            'user',
            'attendances',
            'eventIdName',
            'totalAttendanceCount',
            'attendanceGrowthRateLastMonth',
            'attendanceRateLastMonth',
            'aggregatedChartDataForAttended',
            'aggregatedChartDataForAbsent'

        ));
    }

    public function store(StoreAttendanceRequest $request)
    {
        try {
            $validated = $request->validated();
            $isUserAlreadyRecorded = $this->attendanceService->isUserAlreadyRecorded($validated['user_id'], $validated['event_occurrence_id']);

            if ($request->input('status') == 'eventDone') {
                $this->attendanceService->storeMultipleAbsentRecord($request['event_occurrence_id']);
                return response()->json(['message' => 'All members has record']);
            }
            if ($isUserAlreadyRecorded) {
                return response()->json(['error' => 'User already has record for this event']);
            }

            Attendance::create($validated);
            $attendance = $this->attendanceService->getAllAttendancePaginated();
            if (method_exists($attendance, 'withPath')) {
                $attendance->withPath(route('admin.attendance.create'));
            }

            if ($request->ajax()) {
                $attendancesListView = view("admin.attendance.create-recent-attendance-list", compact('attendance'))->render();
                return response()->json([
                    'list' => $attendancesListView,
                    'message' => 'Record recorded Successfully'
                ]);
            }

        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'There is an error recording attendance']);
        }
    }

    public function create(Request $request)
    {
        try {
            $todaysScheduleEvent = $this->eventService->getTodaysScheduledEvents();
            $attendance = $this->attendanceService->getAllAttendancePaginated();
            $locale = $request['local'];
            $autoCorrectNames = User::filter([
                'memberName' => $request['member-search'],
                'locale' => $request['locale']
            ])->get();

            if ($request->ajax()) {

                $recentAttendance = view('admin.attendance.create-recent-attendance-list', compact('todaysScheduleEvent', 'attendance'))->render();
                return response()->json([
                    'autoCorrctNameList' => $autoCorrectNames,
                    'list' => $recentAttendance,
                ]);
            }

            return view('admin.attendance.create', compact('todaysScheduleEvent', 'attendance'));
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'something went wrong']);
        }
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