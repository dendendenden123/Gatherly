<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\User;

class AttendanceController extends Controller
{
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

    public function show(Request $request, $id)
    {
        $events = Event::select(['id', 'event_name'])->get();
        $user = User::find($id);
        $countTotalAttendance = Attendance::filter(['user_id' => $id, 'status' => 'present'])->count();
        $attendanceGrowthRateLastMonth = self::getAttendanceGrowthRateLastMonth($id);
        $attendanceRateLastMonth = self::getAttendanceRateLastMonth($id);
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

    public function checkIn()
    {
        $events = Event::with([
            'event_occurrences' => function ($query) {
                $query->whereBetween('occurrence_date', [
                    Carbon::today()->startOfDay(),
                    Carbon::today()->endOfDay()
                ])->where('attendance_checked', 0)
                    ->select('id', 'event_id', 'start_time');
            }
        ])->whereHas('event_occurrences', function ($query) {
            $query->whereBetween('occurrence_date', [
                Carbon::today()->startOfDay(),
                Carbon::today()->endOfDay()
            ]);
        })->select('id', 'event_name')
            ->get();


        return view('admin.attendance.check-in', compact('events'));
    }

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

    private function getAttendanceRateLastMonth($user_id)
    {
        $presentCount = Attendance::filter([
            'user_id' => $user_id,
            'status' => 'present',
            'start_date' => now()->subMonth()->startOfMonth(),
            'end_date' => now()->subMonth()->endOfMonth()
        ])->count();

        $absentCount = Attendance::filter([
            'user_id' => $user_id,
            'status' => 'absent',
            'start_date' => now()->subMonth()->startOfMonth(),
            'end_date' => now()->subMonth()->endOfMonth()
        ])->count();

        $total = $presentCount + $absentCount;

        if ($total === 0) {
            return 0; // Prevent division by zero
        }

        return intval(($presentCount / $total) * 100);
    }
}
