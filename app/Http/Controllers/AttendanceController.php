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
        $events = Event::all();
        $search = $request->input('search');
        $start_date = $request->input('start_date') ? $request->input('start_date') : now()->subYear();
        $end_date = $request->input('end_date') ? $request->input('end_date') : now();
        $from = Carbon::parse($start_date);
        $to = Carbon::parse($end_date);
        $status = $request->input('status') === "*" ? '' : $request->input('status');
        $event_id = $request->input('event_id');

        logger($request);

        $attendances = Attendance::with(['event_occurrence.event', 'user'])
            ->whereBetween('updated_at', [$from, $to])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->whereHas('user', function ($query) use ($search) {
                $query->when($search, function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%");
                });
            })
            ->whereHas("event_occurrence.event", function ($query) use ($event_id) {
                $query->when($event_id, function ($q) use ($event_id) {
                    $q->where('id', $event_id);
                });
            })
            ->orderByDesc('updated_at')
            ->simplePaginate(6);

        if ($request->ajax()) {
            return view("admin.attendance.index-attendance-list", compact('attendances', 'events'))->render();
        }
        return view('admin.attendance.index', compact('attendances', "events"));
    }

    public function show(Request $request, $id)
    {
        $user = User::with('attendances', 'attendances.event_occurrence')->findOrFail($id);
        $attendances = $user->attendances()->paginate(5);

        if ($request->ajax()) {
            return view('admin.attendance.show-attendance-list', compact('user', 'attendances'))->render();
        }

        return view('admin.attendance.show', compact('user', 'attendances'));
    }
}
