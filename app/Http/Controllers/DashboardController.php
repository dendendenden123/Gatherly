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
            $query->whereNot('role_id', '0');
        })->count();

        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY);
        $weeklyAttendance = Attendance::whereBetween('updated_at', [$startOfWeek, $endOfWeek])
            ->where('status', 'present')
            ->count();

        $upcomingEvents = EventOccurrence::with('event')
            ->whereDate('occurrence_date', '>=', Carbon::today())
            ->orderBy('occurrence_date')
            ->limit(5)
            ->get();
        $upcomingEventsCount = EventOccurrence::whereDate('occurrence_date', '>=', Carbon::today())->count();

        $recentMembers = User::orderBy('created_at', 'desc')->limit(5)->get(['id', 'first_name', 'middle_name', 'last_name', 'email', 'created_at', 'status']);

        $startOfThisWeek = Carbon::now()->startOfWeek();
        $endOfThisWeek = Carbon::now()->endOfWeek();
        $birthdaysThisWeek = User::whereNotNull('birthdate')
            ->whereRaw("DATE_FORMAT(birthdate, '%m-%d') >= ?", [$startOfThisWeek->format('m-d')])
            ->whereRaw("DATE_FORMAT(birthdate, '%m-%d') <= ?", [$endOfThisWeek->format('m-d')])
            ->orderByRaw("DATE_FORMAT(birthdate, '%m-%d')")
            ->limit(7)
            ->get(['id', 'first_name', 'middle_name', 'last_name', 'birthdate']);

        // Attendance trend (last 8 weeks, present counts)
        $trendStart = Carbon::now()->subWeeks(7)->startOfWeek();
        $trendEnd = Carbon::now()->endOfWeek();
        $weeklyTrend = Attendance::select(
            DB::raw("YEAR(updated_at) as y"),
            DB::raw("WEEK(updated_at, 1) as w"),
            DB::raw("COUNT(CASE WHEN status='present' THEN 1 END) as present")
        )
            ->whereBetween('updated_at', [$trendStart, $trendEnd])
            ->groupBy('y', 'w')
            ->orderBy('y')
            ->orderBy('w')
            ->get();
        $chartLabels = $weeklyTrend->map(function ($row) {
            return $row->y . '-W' . str_pad($row->w, 2, '0', STR_PAD_LEFT);
        });
        $chartValues = $weeklyTrend->pluck('present');

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
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
        ]);
    }
}
