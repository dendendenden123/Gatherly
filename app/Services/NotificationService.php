<?php

namespace App\Services;

use Auth;
use App\Services\UserService;
use App\Models\Notification;
use App\Models\User;


class NotificationService
{

    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function getNotificationsByTab($tab, $query = null)
    {
        $user = User::find(Auth::id());
        $query = $query ?? $user->receivedNotifications();
        switch ($tab) {
            case 'unread':
                $query->wherePivot('read_at', null);
                break;
            case 'alerts':
                $query->where('category', 'alert');
                break;
            case 'announcements':
                $query->where('category', 'announcement');
                break;
            case 'event':
                $query->where('category', 'event');
                break;
            case 'reminder':
                $query->where('category', 'reminder');
                break;
            default:
                // all
                break;
        }

        return $query->latest()->paginate(5)->appends(['tab' => $tab]);
    }

    public function getUserNotifications($userId, $userAssociation = null)
    {

        $userRoles = $this->userService->getUsersRoles($userId);
        $audiences = array_merge(['all', $userAssociation], $userRoles);

        // Fetch notifications targeted to any of the user's audiences
        $notifications = Notification::query()
            ->when(!empty($audiences), function ($q) use ($audiences) {
                $q->whereIn('recipient_group', $audiences);
            });

        return $notifications;
    }

    public function getUserUnreadNotif($userId)
    {
        $user = User::find($userId);
        return $user->receivedNotifications()
            ->wherePivot('read_at', null)
            ->get();
    }
}