<?php

namespace App\Http\Controllers;


use App\Services\AttendanceService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Models\EventOccurrence;
use App\Models\User;
use App\Models\Sermon;
use App\Models\Log;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
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

    public function profile()
    {
        $user = User::findOrFail(Auth::id());
        return view('member.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = User::with('officers')->findOrFail(Auth::id());
        return view('member.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {

        try {
            $validated = $request->validate([
                'id' => 'required|integer',
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'middle_name' => 'nullable|string|max:100',
                'email' => 'required|email|max:255  ',
                'password' => 'nullable|string|min:8|confirmed',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:100',
                'locale' => 'nullable|string|max:100',
                'purok_grupo' => 'nullable|string|max:100',
                'birthdate' => 'nullable|date',
                'sex' => 'nullable|in:male,female,other',
                'baptism_date' => 'nullable|date',
                'marital_status' => 'required|string|in:single,married,separated,widowed,annulled',
                'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'document_image' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:4096',
                'status' => 'nullable|in:active,inactive,suspended',
                'is_Verify' => 'boolean',
            ]);

            $user = User::findOrFail($validated['id']);

            //logs action
            Log::create([
                'user_id' => Auth::id(),
                'action' => 'update',
                'description' => 'Update user account. Account detail: ' . $user,
            ]);

            if ($request->hasFile('profile_image')) {
                if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                    Storage::disk('public')->delete($user->profile_image);
                }

                $path = $request->file('profile_image')->store('profiles', 'public');
                $validated['profile_image'] = $path;
            }

            if ($request->hasFile('document_image')) {
                if ($user->document_image && Storage::disk('public')->exists($user->document_image)) {
                    Storage::disk('public')->delete($user->document_image);
                }

                $path = $request->file('document_image')->store('profiles', 'public');
                $validated['document_image'] = $path;
            }


            $user->update($validated);
            return redirect()->back()->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            \Log::error('Updating user data failed: ' . $e->getMessage());
            return redirect()->back()->with('error', $e);
        }
    }
}
