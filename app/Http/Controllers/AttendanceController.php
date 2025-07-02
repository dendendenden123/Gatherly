<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {

        $attendance = Attendance::with(['user', 'event'])
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('attendances')
                    ->groupBy('user_id');
            })
            ->orderBy('created_at', 'desc')
            ->simplePaginate(5);

        if ($request->ajax()) {
            return view("admin.attendance.member-attendance-list", compact('attendance'))->render();
        }

        return view('admin.attendance.index', compact('attendance'));
    }

    public function searchMembers(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        // $attendance = Attendance::with(['user', 'event'])
        //     ->whereHas('user', function ($query) use ($searchTerm) {
        //         $query->where('name', 'like', "%{$searchTerm}%");
        //     })
        //     ->orderBy('created_at', 'desc')
        //     ->simplePaginate(5); 

        $attendance = "No record found";

        if ($request->ajax()) {
            return view("admin.attendance.member-attendance-list", compact('attendance'))->render();
        }

        //return view('admin.attendance.index', compact('attendance'));
    }
}
