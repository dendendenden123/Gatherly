<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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
            'searchByName' => $request->input('search'),
            'from' => Carbon::parse($from_date),
            'to' => Carbon::parse($to),
            'status' => $request->input('status', '') === "*" ? '' : $request->input('status'),
            'eventId' => $request->input('event_id'),
        ];

        $attendances = Attendance::filter($filters)
            ->orderByDesc('id')
            ->simplePaginate(6);

        if ($request->ajax()) {
            return view("admin.attendance.index-attendance-list", compact('attendances', 'events'))->render();
        }
        return view('admin.attendance.index', compact('attendances', "events"));
    }

    public function show(Request $request, $id)
    {
        $events = Event::select(['id', 'event_name'])->get();
        $user = User::find($id)->firstOrFail();
        $countTotalAttendance = Attendance::filter(['userId' => $id])->count();
        $percentageDifferentFromLastMonth = self::getPercentageDifferentFromLastMonth($id);
        $attendances = Attendance::filter(['userId' => $id])->paginate(5);

        if ($request->ajax()) {
            return view('admin.attendance.show-attendance-list', compact('attendances'))->render();
        }

        return view('admin.attendance.show', compact(
            'user',
            'attendances',
            'events',
            'countTotalAttendance',
            'percentageDifferentFromLastMonth'
        ));
    }

    private function getPercentageDifferentFromLastMonth($id)
    {
        $countLastMonthAttendance = Attendance::filter([
            'userId' => $id,
            'from' => now()->subMonth()->startOfMonth(),
            'to' => now()->subMonth()->endOfMonth()
        ])->count();

        $countLastTwoMonthAttendance = Attendance::filter([
            'userId' => $id,
            'from' => now()->subMonth(2)->startOfMonth(),
            'to' => now()->subMonth(2)->endOfMonth()
        ])->count();
        if ($countLastTwoMonthAttendance === 0) {
            return ['value' => 100, 'sign' => 'positive'];
        }
        if ($countLastMonthAttendance === 0) {
            return ['value' => 100, 'sign' => 'negative'];
        }

        if ($countLastMonthAttendance >= $countLastTwoMonthAttendance) {
            $countDifference = $countLastMonthAttendance - $countLastTwoMonthAttendance;
            return ['value' => ($countDifference / $countLastMonthAttendance), 'sign' => 'positive'];
        }
        $countDifference = $countLastTwoMonthAttendance - $countLastMonthAttendance;
        return ['value' => ($countDifference / $countLastTwoMonthAttendance), 'sign' => 'negative'];
    }
}
