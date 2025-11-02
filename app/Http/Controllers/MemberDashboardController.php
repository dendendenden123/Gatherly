<?php

namespace App\Http\Controllers;


use App\Services\AttendanceService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Models\EventOccurrence;
use App\Models\User;
use App\Models\Sermon;
use App\Services\EventService;
use Carbon\Carbon;
use Auth;

class MemberDashboardController extends Controller
{
    protected EventService $eventService;
    protected AttendanceService $attendanceService;
    protected NotificationService $notificationService;
    protected $userId;
    protected $user;
    public function __construct(EventService $eventService, AttendanceService $attendanceService, NotificationService $notificationService)
    {
        $this->eventService = $eventService;
        $this->attendanceService = $attendanceService;
        $this->notificationService = $notificationService;
        $this->userId = Auth::id();
        $this->user = User::find($this->userId);
    }
    public function index()
    {
        $upcomingEvents = $this->eventService->getUpcomingEvent()->take(5);
        $missedEvents = $this->eventService->getEventsMissedByUser($this->userId)->take(5);
        $assignedPendingTaskCount = $this->user->assignedTasks()->where('status', 'pending')->count();
        $userAttendanceRateLastMonth = $this->attendanceService->getAttendanceRateLastMonth($this->userId);
        $unreadNotifsCounts = $this->notificationService->getUserUnreadNotif($this->userId)->count();
        $attendances = $this->attendanceService->getFilteredAttendances($this->userId)->take(5);
        $sermons = Sermon::query()->limit(5)->paginate(10);
        $upcomingEventsCount = EventOccurrence::whereBetween('occurrence_date', [
            Carbon::today(),
            Carbon::today()->addWeek()
        ])->count();


        return view('member.dashboard', compact(
            'upcomingEvents',
            'upcomingEventsCount',
            'assignedPendingTaskCount',
            'missedEvents',
            'userAttendanceRateLastMonth',
            'unreadNotifsCounts',
            'attendances',
            'sermons'
        ));
    }
}
