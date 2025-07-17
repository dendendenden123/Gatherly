<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\User;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $start_date = $request->input('star_date') ? $request->input('star_date') : '1914-01-01';
        $end_date = $request->input('end_date');
        $status = $request->input('status') === "*" ? '' : $request->input('status');
        $event_id = $request->input('event_id');

        logger($request);


        $users = User::with('attendances')
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            })
            ->whereHas('attendances', function ($query) use ($status, $start_date, $end_date, $event_id) {
                $query->when($status, function ($q) use ($status) {
                    $q->latest('id')->where('status', $status);
                });

                $query->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                    $q->latest('id')->whereBetween('created_at', [$start_date, $end_date]);
                });

                $query->when($event_id, function ($q) use ($event_id) {
                    $q->where('id', $event_id);
                });

            })
            ->orderByDesc('updated_at')
            ->simplePaginate(6);

        $events = Event::all();

        if ($request->ajax()) {
            return view("admin.attendance.index-attendance-list", compact('users', 'events'))->render();
        }
        return view('admin.attendance.index', compact('users', "events"));
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
