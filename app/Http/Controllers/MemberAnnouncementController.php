<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Services\NotificationService;
use App\Models\Event;
use App\Models\User;

class MemberAnnouncementController extends Controller
{
    protected UserService $userService;
    protected NotificationService $notificationService;
    public function __construct(UserService $userService, NotificationService $notificationService)
    {
        $this->userService = $userService;
        $this->notificationService = $notificationService;
    }
    public function index()
    {
        $userId = Auth::id();
        $userAssociation = $this->userService->getUserAssociation($userId);
        $notifications = $this->notificationService->getUserNotifications($userId, $userAssociation);
        $events = Event::filter(['status' => 'upcoming'])->orderBy('start_date')->take(12)->get();

        return view('member.announcement', compact('events', 'notifications'));
    }
}
