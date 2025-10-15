<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\User;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class ReportController extends Controller
{

    protected AttendanceService $attendanceService;
    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }
    public function index(Request $request)
    {
        try {

            $totalAttendance = Attendance::filter();

            return view('admin.reports.index');
        } catch (\Exception $e) {
            logger()->error('Error in ReportController@index: ' . $e->getMessage(), ['exception' => $e]);
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while generating the report.'], 500);
            }
            return redirect()->back()->with('error', 'An error occurred while generating the report.');
        }
    }
}

