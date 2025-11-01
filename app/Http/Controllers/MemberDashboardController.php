<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\EventOccurrence;
use App\Services\EventService;
use Carbon\Carbon;
use Auth;

class MemberDashboardController extends Controller
{
    protected EventService $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }
    public function index()
    {
        $upcomingEvents = EventOccurrence::with('event')
            ->whereDate('occurrence_date', '>=', Carbon::today())
            ->orderBy('occurrence_date', )
            ->limit(5)
            ->get();
        $missedEvents = $this->eventService->getEventsMissedByUser(Auth::id());

        return view('member.dashboard', compact('upcomingEvents', 'missedEvents'));
    }
}
