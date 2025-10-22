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
            logger($request->all());

            $getFilteredData = $this->reportService->getAttendanceFilteredReport($request->all())->get()->map(function ($item) {
                return $item->event_occurrence->event->event_name;
            });

            dd($getFilteredData);

            $data = [
                'charts' => [
                    'attendance' => [ 
                        'weekly' => [
                            'x' => ["Oct 2", "Oct 9", "Oct 16", "Oct 23", "Oct 30", "Nov 6", "Nov 13"],
                            'series' => [
                                [
                                    'name' => "Sunday Services",
                                    'data' => [320, 335, 342, 310, 298, 325, 340],
                                ],
                                [
                                    'name' => "Youth Events",
                                    'data' => [65, 72, 78, 70, 68, 75, 80],
                                ],
                                [
                                    'name' => "Bible Studies",
                                    'data' => [40, 42, 45, 38, 35, 40, 44],
                                ],
                            ],
                        ],
                        'monthly' => [
                            'x' => ["Jun", "Jul", "Aug", "Sep", "Oct", "Nov"],
                            'series' => [
                                [
                                    'name' => "Sunday Services",
                                    'data' => [1250, 1320, 1390, 1410, 1470, 1500],
                                ],
                                [
                                    'name' => "Youth Events",
                                    'data' => [300, 320, 350, 360, 380, 400],
                                ],
                                [
                                    'name' => "Bible Studies",
                                    'data' => [180, 190, 200, 210, 220, 230],
                                ],
                            ],
                        ],
                        'yearly' => [
                            'x' => ["2019", "2020", "2021", "2022", "2023", "2024"],
                            'series' => [
                                [
                                    'name' => "Sunday Services",
                                    'data' => [12000, 9000, 11000, 13000, 14500, 15200],
                                ],
                                [
                                    'name' => "Youth Events",
                                    'data' => [2600, 2400, 2800, 3200, 3800, 4200],
                                ],
                                [
                                    'name' => "Bible Studies",
                                    'data' => [1500, 1300, 1600, 1800, 2100, 2300],
                                ],
                            ],
                        ],
                        'bars' => [
                            'attendance' => ["Sunday AM", "Sunday PM", "Youth", "Bible Study", "Men's", "Women's", "Prayer"],
                            'data' => [342, 215, 78, 45, 32, 28, 15],
                        ],
                    ],

                    'engagement' => [
                        'weekly' => [
                            'x' => ["W1", "W2", "W3", "W4"],
                            'series' => [
                                ['name' => "Engagement", 'data' => [70, 75, 78, 80]],
                            ],
                        ],
                        'monthly' => [
                            'x' => ["Jun", "Jul", "Aug", "Sep", "Oct", "Nov"],
                            'series' => [
                                ['name' => "Engagement", 'data' => [68, 70, 72, 74, 78, 80]],
                            ],
                        ],
                        'yearly' => [
                            'x' => ["2020", "2021", "2022", "2023", "2024"],
                            'series' => [
                                ['name' => "Engagement", 'data' => [60, 65, 70, 75, 78]],
                            ],
                        ],
                        'bars' => [
                            'attendance' => ["Groups", "Volunteers", "Donations"],
                            'data' => [120, 85, 60],
                        ],
                    ],

                    'demographics' => [
                        'weekly' => [
                            'x' => ["Binhi", "Kadiwa", "Buklod"],
                            'series' => [
                                ['name' => "Count", 'data' => [50, 80, 120]],
                            ],
                        ],
                        'monthly' => [
                            'x' => ["Binhi", "Kadiwa", "Buklod"],
                            'series' => [
                                ['name' => "Count", 'data' => [300, 420, 600]],
                            ],
                        ],
                        'yearly' => [
                            'x' => ["Binhi", "Kadiwa", "Buklod"],
                            'series' => [
                                ['name' => "Count", 'data' => [3600, 4600, 7200]],
                            ],
                        ],
                        'bars' => [
                            'attendance' => ["Children", "Youth", "Adults", "Seniors"],
                            'data' => [90, 150, 320, 60],
                        ],
                    ],

                ],
                'tables' => [
                    //no data yet
                ]
            ];

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

