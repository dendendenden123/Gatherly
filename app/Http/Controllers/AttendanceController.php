<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\EventOccurrence;
use App\Models\User;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('query');

        $users = User::with('attendances')
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            })
            ->orderByDesc('updated_at')
            ->simplePaginate(6);


        if ($request->ajax()) {
            return view("admin.attendance.index-attendance-list", compact('users'))->render();
        }
        return view('admin.attendance.index', compact('users'));
    }

    public function show(Request $request, $id)
    {
        $user = User::with('attendances', 'attendances.event_occurrence')->findOrFail($id);

        // if ($request->ajax()) {
        //     $attedance = $user->attendances;
        //     return view('admin.attendance.show-attendance-list', compact('attendance'))->render();
        // }


        return view('admin.attendance.show', compact('user'));
    }
}
