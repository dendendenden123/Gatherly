<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\User;
use App\Services\AttendanceService;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class ReportController extends Controller
{

    protected AttendanceService $attendanceService;
    protected ReportService $reportService;
    public function __construct(AttendanceService $attendanceService, ReportService $reportService)
    {
        $this->attendanceService = $attendanceService;
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        try {
            $month = json_encode($this->reportService->getReportData($request));

            return view('admin.reports.index', compact('month'));
        } catch (\Exception $e) {
            logger()->error('Error in ReportController@index: ' . $e->getMessage(), ['exception' => $e]);
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while generating the report.'], 500);
            }
            return redirect()->back()->with('error', 'An error occurred while generating the report.');
        }
    }
}

