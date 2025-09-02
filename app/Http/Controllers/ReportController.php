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
            $EventParticipationChartData = self::getEventParticipationChartData($request);
            $demographicChartData = self::getDemographicChartData($request);

            if ($request->ajax()) {
                $chart = view('admin.reports.index-chart', [
                    'attendanceChartData' => $attendanceChartData,
                    'memberShipGrowthChartData' => $memberShipGrowthChartData,
                    'EventParticipationChartData' => $EventParticipationChartData,
                    'demographicChartData' => $demographicChartData,
                ])->render();
                return response()->json(['chart' => $chart]);
            }

            return view('admin.reports.index', [
                'attendanceChartData' => $attendanceChartData,
                'memberShipGrowthChartData' => $memberShipGrowthChartData,
                'EventParticipationChartData' => $EventParticipationChartData,
                'demographicChartData' => $demographicChartData,
                'events' => $events,
            ]);
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

    //==================================================
    //===Generate membership growth chart data (weekly, monthly, or yearly) within the given date range
    //==================================================
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
        // Get top 5 events with highest attendance
        $topEvents = Event::select('events.id', 'events.event_name')
            ->join('event_occurrences', 'events.id', '=', 'event_occurrences.event_id')
            ->join('attendances', 'event_occurrences.id', '=', 'attendances.event_occurrence_id')
            ->where('attendances.status', 'present')
            ->selectRaw('COUNT(attendances.id) as total_attendance')
            ->groupBy('events.id', 'events.event_name')
            ->orderByDesc('total_attendance')
            ->limit(5)
            ->get();

        // Prepare data for horizontal bar chart
        $labels = $topEvents->pluck('event_name')->toArray();
        $data = $topEvents->pluck('total_attendance')->toArray();

        return [
            'chartType' => 'bar',
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Attendance',
                    'data' => $data,
                    'backgroundColor' => [
                        '#FF6384', // Red
                        '#36A2EB', // Blue
                        '#FFCE56', // Yellow
                        '#4BC0C0', // Teal
                        '#9966FF'  // Purple
                    ],
                    'borderColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF'
                    ],
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    private function getDemographicChartData($request)
    {
        // Age group definitions based on typical church organization:
        // Binhi: 0-17 years (children and youth)
        // Kadiwa: 18-35 years (young adults)
        // Buklod: 36+ years (adults and seniors)

        $demographicData = User::selectRaw('
            CASE 
                WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) <= 17 THEN "Binhi"
                WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) <= 35 THEN "Kadiwa"
                ELSE "Buklod"
            END as age_group,
            sex,
            COUNT(*) as count
        ')
            ->groupBy('age_group', 'sex')
            ->orderBy('age_group')
            ->orderBy('sex')
            ->get();

        // Prepare data for pie chart
        $labels = [];
        $data = [];
        $backgroundColor = [
            '#FF6384',
            '#36A2EB',
            '#FFCE56',
            '#4BC0C0', // Binhi Male, Binhi Female, Kadiwa Male, Kadiwa Female
            '#9966FF',
            '#FF9F40',
            '#FF6384',
            '#C9CBCF'  // Buklod Male, Buklod Female, additional colors
        ];

        foreach ($demographicData as $item) {
            $label = $item->age_group . ' - ' . ucfirst($item->sex);
            $labels[] = $label;
            $data[] = $item->count;
        }

        return [
            'chartType' => 'pie',
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => array_slice($backgroundColor, 0, count($data)),
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff'
                ]
            ]
        ];
    }
}

