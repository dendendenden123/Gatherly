<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //==================================================
    //=== Show the All reports
    //==================================================
    public function index(Request $request)
    {
        try {
            logger('report that index', [$request->all()]);
            $attendanceChartData = self::getAttendanceChartData($request);
            $memberShipGrowthChartData = self::getMemberShipGrowthChartData($request);
            $events = Event::select('id', 'event_name')->get();

            logger('result for attendanceChartData', [$attendanceChartData]);

            if ($request->ajax()) {
                $chart = view('admin.reports.index-chart', compact(
                    'attendanceChartData',
                    'memberShipGrowthChartData'
                ))->render();
                return response()->json(['chart' => $chart]);
            }
            return view('admin.reports.index', compact(
                'attendanceChartData',
                'memberShipGrowthChartData',
                'events'
            ));
        } catch (\Exception $e) {
            logger()->error('Error in ReportController@index: ' . $e->getMessage(), ['exception' => $e]);
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while generating the report.'], 500);
            }
            return redirect()->back()->with('error', 'An error occurred while generating the report.');
        }
    }

    //==================================================
    //===Prepares attendance chart data (labels and datasets) 
    //===by aggregating present and absent records for visualization.
    //==================================================
    private function getAttendanceChartData($request)
    {
        $usersCount = User::count();
        $attendanceData = Attendance::getAggregatedChartData([...$request->all(), 'status' => 'present'])->toArray();
        return [
            'chartType' => 'line',
            'labels' => array_map(function ($item) {
                return $item['label'];
            }, $attendanceData),
            'datasets' => [
                [
                    'label' => 'Attendance',
                    'data' => array_map(function ($item) use ($usersCount) {
                        return ($item['value'] / ($item['event_count'] * $usersCount)) * 100;
                    }, $attendanceData),
                ],
            ]
        ];
    }

    private function getMemberShipGrowthChartData($request)
    {
        $usersCount = User::count();
        $attendanceData = Attendance::getAggregatedChartData([...$request->all(), 'status' => 'present'])->toArray();
        return [
            'chartType' => 'bar',
            'labels' => array_map(function ($item) {
                return $item['label'];
            }, $attendanceData),
            'datasets' => [
                [
                    'label' => 'Attendance',
                    'data' => array_map(function ($item) use ($usersCount) {
                        return ($item['value'] / ($item['event_count'] * $usersCount)) * 100;
                    }, $attendanceData),
                ],
            ]
        ];
    }
}

