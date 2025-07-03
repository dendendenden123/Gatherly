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
            $search = $request->input('query');

            $attendance = Attendance::with(['user', 'event'])
                ->whereIn('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('attendances')
                        ->groupBy('user_id');
                })
                ->whereHas('user', function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->orderBy('created_at', 'desc')
                ->simplePaginate(5);

           if ($request->ajax()) {
            return view("admin.attendance.member-attendance-list", compact('attendance'))->render();
        }
            return view('admin.attendance.index', compact('attendance'));
    
    }
}
