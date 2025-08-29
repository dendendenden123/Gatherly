<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //==================================================
    //=== Show the All reports
    //==================================================
    public function index(Request $request)
    {
        $attendanceChartData = self::getAttendanceChartData($request);
        return view('admin.reports.index', compact('attendanceChartData'));
    }

    //==================================================
    //===Prepares attendance chart data (labels and datasets) 
    //===by aggregating present and absent records for visualization.
    //==================================================
    private function getAttendanceChartData($request)
    {
        $attendanceData = Attendance::getAggregatedChartData([...$request->all(), 'status' => 'present'])->toArray();
        return [
            'chartType' => 'line',
            'labels' => array_map(function ($item) {
                return $item['label'];
            }, $attendanceData),
            'datasets' => [
                [
                    'label' => 'Attendance',
                    'data' => array_map(function ($item) {
                        return $item['value'];
                    }, $attendanceData),
                ],
            ]
        ];
    }
}

