<?php

namespace App\Http\Controllers;
use App\Models\EventOccurrence;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\User;


class AttendanceController extends Controller
{
    //====================================
    //===Show all attendance record
    //===================================
    public function index(Request $request)
    {
        $events = Event::select(['id', 'event_name'])->get();
        $from_date = $request->input('start_date') ?? now()->subYear();
        $to = $request->input('end_date') ?? now();

        $filters = [
            'search_by_name' => $request->input('search'),
            'start_date' => Carbon::parse($from_date),
            'end_date' => Carbon::parse($to),
            'status' => $request->input('status', '') === "*" ? '' : $request->input('status'),
            'event_id' => $request->input('event_id'),
        ];

        $attendances = Attendance::filter($filters)
            ->orderByDesc('id')
            ->simplePaginate(6);

        if ($request->ajax()) {
            $attendancesListView = view("admin.attendance.index-attendance-list", compact('attendances', 'events'))->render();

            return response()->json([
                'list' => $attendancesListView
            ]);
        }
        return view('admin.attendance.index', compact('attendances', "events"));
    }

    //====================================
    //===Show Attendance record of specific member
    //===================================
    public function show(Request $request, $id)
    {
        $events = Event::select(['id', 'event_name'])->get();
        $user = User::find($id);
        $countTotalAttendance = Attendance::filter(['user_id' => $id, 'status' => 'present'])->count();
        $attendanceGrowthRateLastMonth = self::getAttendanceGrowthRateLastMonth($id);
        $attendanceRateLastMonth = Attendance::getAttendanceRateLastMonth($id);
        $attendances = Attendance::filter([...$request->all(), 'user_id' => $id])->paginate(5);
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
            'events',
            'countTotalAttendance',
            'attendanceGrowthRateLastMonth',
            'attendanceRateLastMonth',
            'aggregatedChartDataForAttended',
            'aggregatedChartDataForAbsent'

        ));
    }

    //====================================
    //===Create New Attendance Record to attendances table
    //===================================
    public function store(Request $request)
    {
        //check if event is over then record all absensee
        if ($request['status'] == 'eventDone') {
            self::storeMultipleAbsentRecord($request['event_occurrence_id']);
            return response()->json(['message' => 'All members has record']);
        }
        try {
            $validated = $request->validate([
                'user_id' => ['required', 'integer', 'exists:users,id'],
                'event_occurrence_id' => ['required', 'integer', 'exists:event_occurrences,id'],
                'service_date' => ['nullable', 'date'],
                'check_in_time' => ['nullable', 'date_format:H:i:s'],
                'check_out_time' => ['nullable', 'date_format:H:i:s', 'after:check_in_time'],
                'attendance_method' => ['nullable', 'string'],
                'biometric_data_id' => ['nullable', 'integer'],
                'recorded_by' => ['nullable', 'integer', 'exists:users,id'],
                'status' => ['required', 'string', 'in:present,absent,eventDone'],
                'notes' => ['nullable', 'string', 'max:500'],
            ]);
            $validated['service_date'] = now();
            $validated['check_in_time'] = now()->format('H:i');
            $isUserAlreadyRecorded = self::isUserAlreadyRecorded($validated['user_id'], $validated['event_occurrence_id']);

            if ($isUserAlreadyRecorded) {
                return response()->json(['error' => 'User already has record for this event']);
            }

            Attendance::create($validated);
            $attendance = Attendance::query()
                ->orderByDesc('id')
                ->simplePaginate(6);

            if ($request->ajax()) {
                $attendancesListView = view("admin.attendance.check-in-recent-attendance-list", compact('attendance'))->render();

                return response()->json([
                    'list' => $attendancesListView,
                    'message' => 'Record recorded Successfully'
                ]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => 'There is an error. Please select a member and event to proceed']);
        }
    }

    //====================================
    //===View the check in page
    //===================================
    public function checkIn(Request $request)
    {
        $locale = $request['local'];
        $todaysScheduleEvent = self::getTodaysScheduledEvents();
        $autoCorrectNames = User::filter([
            'memberName' => $request['member-search'],
            'locale' => $request['locale']
        ])->get();
        $attendance = Attendance::with(['user', 'event_occurrence'])->orderByDesc('created_at')->paginate(5);

        if ($request->ajax()) {
            $recentAttendance = view('admin.attendance.check-in-recent-attendance-list', compact('todaysScheduleEvent', 'attendance'))->render();
            return response()->json([
                'autoCorrctNameList' => $autoCorrectNames,
                'list' => $recentAttendance,
            ]);
        }

        return view('admin.attendance.check-in', compact('todaysScheduleEvent', 'attendance'));
    }

    private function getSpecificMemberAttendanceChartData()
    {

    }

    //====================================
    //===Fetch all events scheduled for today that haven't been marked as attended yet
    //===================================
    private function getTodaysScheduledEvents()
    {
        return EventOccurrence::with('event')
            ->where('attendance_checked', 0)
            ->where('occurrence_date', [now()->startOfDay(), now()->endOfDay()])
            ->get();
    }

    //====================================
    //===Calculate a user's attendance growth rate by comparing last month and the previous month
    //===================================
    private function getAttendanceGrowthRateLastMonth($user_id)
    {
        $countLastMonthAttendance = Attendance::filter([
            'user_id' => $user_id,
            'status' => 'present',
            'start_date' => now()->subMonth()->startOfMonth(),
            'end_date' => now()->subMonth()->endOfMonth()
        ])->count();

        $countLastTwoMonthAttendance = Attendance::filter([
            'user_id' => $user_id,
            'status' => 'present',
            'start_date' => now()->subMonth(2)->startOfMonth(),
            'end_date' => now()->subMonth(2)->endOfMonth()
        ])->count();

        if ($countLastTwoMonthAttendance === 0 && $countLastMonthAttendance === 0) {
            return ['value' => 0, 'sign' => 'negative'];
        }
        if ($countLastMonthAttendance === 0) {
            return ['value' => 100, 'sign' => 'negative'];
        }
        if ($countLastTwoMonthAttendance === 0) {
            return ['value' => 100, 'sign' => 'positive'];
        }

        if ($countLastMonthAttendance >= $countLastTwoMonthAttendance) {
            $countDifference = $countLastMonthAttendance - $countLastTwoMonthAttendance;
            return ['value' => (intval(($countDifference / $countLastMonthAttendance) * 100)), 'sign' => 'positive'];
        }

        $countDifference = $countLastTwoMonthAttendance - $countLastMonthAttendance;
        return ['value' => (intval(($countDifference / $countLastTwoMonthAttendance) * 100)), 'sign' => 'negative'];
    }



    //====================================
    //===Check if a user already has an attendance record for a specific event occurrence
    //===================================
    private function isUserAlreadyRecorded($userId, $eventOccurenceId)
    {
        return Attendance::where('event_occurrence_id', $eventOccurenceId)->where('user_id', $userId)->exists();
    }

    //====================================
    //===Record all absent users for a given event occurrence and mark attendance as checked
    //===================================
    private function storeMultipleAbsentRecord($eventOccurenceId)
    {
        $presentUser = Attendance::where('event_occurrence_id', $eventOccurenceId)->where('status', 'present')->pluck('user_id');
        $absentUser = User::pluck('id')->diff($presentUser);

        foreach ($absentUser as $id) {
            Attendance::create([
                'user_id' => $id,
                'event_occurrence_id' => $eventOccurenceId,
                'service_date' => now(),
                'check_in_time' => now()->format('H:i'),
                'status' => 'absent'
            ]);
        }
        EventOccurrence::find($eventOccurenceId)->update([
            'attendance_checked' => 1
        ]);
    }
}