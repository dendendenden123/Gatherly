<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('query');

        $attendance = Attendance::with(['user', 'event'])
            // Filter by user search
            ->whereHas('user', function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            })
            //get the latest record each user
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('attendances')
                    ->groupBy('user_id');
            })
            ->orderBy('created_at', 'desc')
            ->simplePaginate(6);

        if ($request->ajax()) {
            return view("admin.attendance.member-attendance-list", compact('attendance'))->render();
        }
        return view('admin.attendance.index', compact('attendance'));
    }

    public function show($id)
    {
        $fromDate = "2025-06-05";
        $attendance = User::with(["events"])
            ->where("id", $id)
            ->firstOrFail();

        return view('admin.attendance.show', compact('attendance'));
    }
}
