<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\EventOccurrence;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalMembers = User::count();
        $activeCount = User::where('status', 'active')->count();
        $inactiveCount = User::where('status', 'inactive')->count();
        $partiallyActiveCount = User::where('status', 'partially-active')->count();
        $expelledCount = User::where('status', 'expelled')->count();
        $volunteersCount = User::whereHas('officers', function ($query) {
            $query->whereNotIn('role_id', [0, 100]);
        })->count();

        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY);
        $weeklyAttendance = Attendance::whereBetween('updated_at', [$startOfWeek, $endOfWeek])
            ->where('status', 'present')
            ->count();

        $upcomingEvents = EventOccurrence::with('event')
            ->whereDate('occurrence_date', '>=', Carbon::today())
            ->orderBy('occurrence_date', )
            ->limit(5)
            ->get();

        $upcomingEventsCount = EventOccurrence::whereBetween('occurrence_date', [
            Carbon::today(),
            Carbon::today()->addWeek()
        ])->count();

        $recentMembers = User::orderBy('created_at', 'desc')->limit(5)->get();

        $startOfThisWeek = Carbon::now()->startOfWeek();
        $endOfThisWeek = Carbon::now()->endOfWeek();
        $birthdaysThisWeek = User::whereNotNull('birthdate')
            ->whereRaw("DATE_FORMAT(birthdate, '%m-%d') >= ?", [$startOfThisWeek->format('m-d')])
            ->whereRaw("DATE_FORMAT(birthdate, '%m-%d') <= ?", [$endOfThisWeek->format('m-d')])
            ->orderByRaw("DATE_FORMAT(birthdate, '%m-%d')")
            ->limit(7)
            ->get(['id', 'first_name', 'middle_name', 'last_name', 'birthdate']);

        // Get the range: 6 months from today
        $trendEnd = Carbon::now();
        $trendStart = Carbon::now()->subMonths(5)->startOfMonth(); // include current month

        // Query actual attendance data
        $monthlyTrend = Attendance::select(
            DB::raw("YEAR(updated_at) as y"),
            DB::raw("MONTH(updated_at) as m"),
            DB::raw("COUNT(CASE WHEN status='present' THEN 1 END) as present")
        )
            ->whereBetween('updated_at', [$trendStart, $trendEnd])
            ->groupBy('y', 'm')
            ->orderBy('y')
            ->orderBy('m')
            ->get()
            ->mapWithKeys(function ($row) {
                $key = Carbon::create($row->y, $row->m)->format('M Y');
                return [$key => $row->present];
            });

        // Generate 6-month list
        $months = collect();
        for ($i = 0; $i < 6; $i++) {
            $monthLabel = Carbon::now()->subMonths(5 - $i)->format('M Y');
            $months->put($monthLabel, $monthlyTrend[$monthLabel] ?? 0);
        }

        // Final data
        $chartLabels = $months->keys();
        $chartValues = $months->values();



        return view('admin.dashboard', [
            'totalMembers' => $totalMembers,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
            'partiallyActiveCount' => $partiallyActiveCount,
            'expelledCount' => $expelledCount,
            'weeklyAttendance' => $weeklyAttendance,
            'upcomingEvents' => $upcomingEvents,
            'upcomingEventsCount' => $upcomingEventsCount,
            'volunteersCount' => $volunteersCount,
            'recentMembers' => $recentMembers,
            'birthdaysThisWeek' => $birthdaysThisWeek,
            'chartLabels' => json_encode($chartLabels),
            'chartValues' => json_encode($chartValues),
        ]);
    }
}
