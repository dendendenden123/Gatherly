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
        $search = $request->input('query');
        $star_date = $request->input('query');
        $end_date = $request->input('query');
        $event_name = $request->input('query');
        $status = $request->input('status') === "*" ? '' : $request->input('status');


        $users = User::with('attendances')
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            })
            ->whereHas('attendances', function ($query) use ($status) {
                $query->when($status, function ($q) use ($status) {
                    $q->latest('id')->where('status', $status);
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
