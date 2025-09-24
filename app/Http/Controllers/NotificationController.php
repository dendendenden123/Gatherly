<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\NotificationService;
use App\Services\UserService;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Auth;

class NotificationController extends Controller
{

    protected NotificationService $notificationService;
    protected UserService $userService;
    protected $user;
    protected $userId;
    public function __construct(NotificationService $notificationService, UserService $userService)
    {
        $this->notificationService = $notificationService;
        $this->userService = $userService;
        $this->userId = Auth::id();
        $this->user = User::find($this->userId);
    }
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');
        $notifications = $this->notificationService->getNotificationsByTab($tab);
        $unreadCount = $this->notificationService->getUserUnreadNotif($this->userId)->count();

        return view('admin.notifications.index', compact('notifications', 'unreadCount', 'tab'));
    }

    public function create()
    {
        $roleNames = Role::query()->pluck('name');
        return view('admin.notifications.create', compact('roleNames'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_group' => 'nullable|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'category' => 'nullable|string|max:100',
        ]);


        Notification::create([
            'recipient_group' => $validated['recipient_group'] ?? null,
            'sender_id' => $this->userId,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'category' => $validated['category'] ?? null,

        ]);

        return back()->with('success', 'Notification queued/sent successfully');
    }

    public function markAllRead()
    {
        $this->notificationService->markAllNotificationsAsRead();
        return back()->with('success', 'All notifications marked as read');
    }

    public function markRead(Notification $notification)
    {
        $this->user->receivedNotifications()
            ->updateExistingPivot($notification->id, ['read_at' => now()]);

        return back()->with('success', 'Notification marked as read');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notification deleted');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'No notifications selected');
        }
        Notification::whereIn('id', $ids)->delete();
        return back()->with('success', 'Selected notifications deleted');
    }

    public function viewMyNotification(Request $request)
    {
        $previousUrl = url()->previous();
        if (Str::contains($previousUrl, 'tab=unread')) {
            $this->notificationService->markAllNotificationsAsRead();
        }

        $tab = $request->query('tab', 'all');
        $userAssociation = $this->userService->getUserAssociation($this->userId);
        $query = $this->notificationService->getUserNotifications($this->userId, $userAssociation);
        $unreadCounts = $this->notificationService->getUserUnreadNotif($this->userId)->count();
        $notfications = $this->notificationService->getNotificationsByTab($tab, $query);

        return view('member.notification', compact('notfications', 'tab', 'unreadCounts'));
    }
}
