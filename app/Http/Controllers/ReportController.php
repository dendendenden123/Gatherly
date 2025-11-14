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
            $totalAttendancetotal = $this->reportService->getAttendanceFilteredReport($request)->count();
            $totalAttendance = $this->reportService->getAttendanceFilteredReport($request, 'present')->count();
            $totalMembers = User::query()->count();
            $engagementRate = $this->reportService->getEngagementRate($request);

            $weeklyAttendance = $this->reportService->getWeeklyAttendance($request);
            $monthlyAttendance = $this->reportService->getMonthlyAttendance($request);
            $yearlyAttendance = $this->reportService->getYearlyAttendance($request);
            $attendanceBars = $this->reportService->getAttendanceBars($request);

            $weeklyEngagement = $this->reportService->getWeeklyEngagement($request);
            $monthlyEngagement = $this->reportService->getMonthlyEngagement($request);
            $yearlyEngagement = $this->reportService->getYearlyEngagement($request);

            $attendanceDetails = json_encode($this->reportService->getAttendanceDetails($request));
            $engagementDetails = json_encode($this->reportService->getEngagementDetails($request));

            $attendanceChart = json_encode([
                'weekly' => $weeklyAttendance,
                'monthly' => $monthlyAttendance,
                'yearly' => $yearlyAttendance,
                'bars' => $attendanceBars,
            ]);

            $engagementChart = json_encode([
                'weekly' => $weeklyEngagement,
                'monthly' => $monthlyEngagement,
                'yearly' => $yearlyEngagement,
                'bars' => $attendanceBars,
            ]);

            return view('admin.reports.index', compact('totalAttendance', 'totalAttendancetotal', 'totalMembers', 'engagementRate', 'attendanceChart', 'engagementChart', 'attendanceDetails', 'engagementDetails'));
        } catch (\Exception $e) {
            logger()->error('Error in ReportController@index: ' . $e->getMessage(), ['exception' => $e]);
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while generating the report.'], 500);
            }
            return redirect()->back()->with('error', 'An error occurred while generating the report.');
        }
    }
}

