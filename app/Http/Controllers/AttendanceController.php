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

        $attendance = User::with()

        // $attendance = Attendance::with(['user', 'event_occurrence'])
        //     // Filter by user search
        //     ->whereHas('user', function ($query) use ($search) {
        //         $query->where('first_name', 'like', "%{$search}%")
        //             ->orWhere('last_name', 'like', "%{$search}%");
        //     })
        //     //get the latest record each user
        //     ->whereIn('id', function ($query) {
        //         $query->select(DB::raw('MAX(id)'))
        //             ->from('attendances')
        //             ->groupBy('user_id');
        //     })
        //     ->orderBy('created_at', 'desc')
        //     ->simplePaginate(6);

        if ($request->ajax()) {
            return view("admin.attendance.index-attendance-list", compact('attendance'))->render();
        }
        return view('admin.attendance.index', compact('attendance'));
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
