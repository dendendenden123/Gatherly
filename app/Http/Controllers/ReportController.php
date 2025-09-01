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
            $events = Event::select('id', 'event_name')->get();
            $attendanceChartData = self::getAttendanceChartData($request);
            $memberShipGrowthChartData = self::getMemberShipGrowthChartData($request);

            if ($request->ajax()) {
                $chart = view('admin.reports.index-chart', [
                    'attendanceChartData' => $attendanceChartData,
                    'memberShipGrowthChartData' => $memberShipGrowthChartData,
                ])->render();
                return response()->json(['chart' => $chart]);
            }

            return view('admin.reports.index', [
                'attendanceChartData' => $attendanceChartData,
                'memberShipGrowthChartData' => $memberShipGrowthChartData,
                'events' => $events,
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while generating the report.'], 500);
            }
            logger()->error('Error in ReportController@index: ' . $e->getMessage(), ['exception' => $e]);
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
        $start_date = $request['start_date'] ?? now()->subCentury();
        $end_date = $request['end_date'] ?? now()->addCentury();
        $aggregate = $request['aggregate'] ?? 'monthly';

        if ($aggregate === 'weekly') {
            $userGrowth = User::whereBetween('created_at', [$start_date, $end_date])
                ->selectRaw('YEAR(created_at) as year, WEEK(created_at, 1) as week, COUNT(*) as total')
                ->groupBy('year', 'week')
                ->orderBy('year')
                ->orderBy('week')
                ->get()
                ->map(function ($item) {
                    return [
                        'label' => $item->year . '-W' . str_pad($item->week, 2, '0', STR_PAD_LEFT),
                        'value' => ($item->total / User::count()) * 100,
                    ];
                });
        } elseif ($aggregate === 'monthly') {
            $userGrowth = User::whereBetween('created_at', [$start_date, $end_date])
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->map(function ($item) {
                    return [
                        'label' => $item->month,
                        'value' => ($item->total / User::count()) * 100,
                    ];
                });
        } elseif ($aggregate === 'yearly') {
            $userGrowth = User::whereBetween('created_at', [$start_date, $end_date])
                ->selectRaw('DATE_FORMAT(created_at, "%Y") as year, COUNT(*) as total')
                ->groupBy('year')
                ->orderBy('year')
                ->get()
                ->map(function ($item) {
                    return [
                        'label' => $item->year,
                        'value' => ($item->total / User::count()) * 100,
                    ];
                });
        } else {
            $userGrowth = collect();
        }
        return [
            'chartType' => 'bar',
            'labels' => $userGrowth->pluck('label'),
            'datasets' => [
                [
                    'label' => 'Membership Growth',
                    'data' => $userGrowth->pluck('value'),
                ]
            ]
        ];
    }

    private function getEventParticipationChartData($request)
    {
        return 'check';
    }
}

