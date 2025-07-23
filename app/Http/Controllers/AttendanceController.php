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
        $to = $request->input('end_datea') ?? now();

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
        $countTotalAttendance = Attendance::filter(['userId' => $id, 'status' => 'present'])->count();
        $attendanceGrowthRateLastMonth = self::getAttendanceGrowthRateLastMonth($id);
        $attendanceRateLastMonth = self::getAttendanceRateLastMonth($id);
        $attendances = Attendance::filter(['userId' => $id])->paginate(5);
        $aggregatedChartData = Attendance::aggregatedChartData([...$request->all(), "userId" => $id]);

        if ($request->ajax()) {
            $chartView = view('admin.attendance.show-attendance-chart', compact("aggregatedChartData"))->render();
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
            'aggregatedChartData'
        ));
    }

    private function getAttendanceGrowthRateLastMonth($user_id)
    {
        $countLastMonthAttendance = Attendance::filter([
            'userId' => $user_id,
            'status' => 'present',
            'start_date' => now()->subMonth()->startOfMonth(),
            'end_date' => now()->subMonth()->endOfMonth()
        ])->count();

        $countLastTwoMonthAttendance = Attendance::filter([
            'userId' => $user_id,
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
            'userId' => $user_id,
            'status' => 'present',
            'start_date' => now()->subMonth()->startOfMonth(),
            'end_date' => now()->subMonth()->endOfMonth()
        ])->count();

        $absentCount = Attendance::filter([
            'userId' => $user_id,
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
