<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAttendanceRequest;
use App\Services\AttendanceService;
use App\Services\EventService;
use App\Models\Attendance;
use App\Models\User;


class AttendanceController extends Controller
{
    protected AttendanceService $attendanceService;
    protected EventService $eventService;
    public function __construct(AttendanceService $attendanceService, EventService $eventService)
    {
        $this->eventService = $eventService;
        $this->attendanceService = $attendanceService;
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
        return view('admin.attendance.index', compact('filteredAttendancesPaginated', "eventIdName"));
    }

    public function show(Request $request, $id = Auth::id())
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
        logger('store method reached');
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
                $attendance->withPath(route('admin.attendance.checkIn'));
            }

            if ($request->ajax()) {
                $attendancesListView = view("admin.attendance.check-in-recent-attendance-list", compact('attendance'))->render();
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

    public function checkIn(Request $request)
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

                $recentAttendance = view('admin.attendance.check-in-recent-attendance-list', compact('todaysScheduleEvent', 'attendance'))->render();
                return response()->json([
                    'autoCorrctNameList' => $autoCorrectNames,
                    'list' => $recentAttendance,
                ]);
            }

            return view('admin.attendance.check-in', compact('todaysScheduleEvent', 'attendance'));
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'something went wrong']);
        }
    }
}