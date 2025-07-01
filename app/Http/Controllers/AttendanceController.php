<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendance::with(['user', 'event'])
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('attendances')
                    ->groupBy('user_id');
            })
            ->orderBy('created_at', 'desc')
            ->Paginate(5);


        return view('admin.attendance.index', compact('attendance'));
    }
}
