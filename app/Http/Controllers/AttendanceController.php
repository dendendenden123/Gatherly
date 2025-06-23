<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendance::with(['user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('user_id')
            ->values();

        return view('admin.attendance.index', compact('attendance'));
    }
}
