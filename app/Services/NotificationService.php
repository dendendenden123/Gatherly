<?php

namespace App\Services;

use Auth;
use App\Services\UserService;
use App\Models\User;


class NotificationService
{

    protected UserService $userService;
    protected $userId;
    protected $user;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->userId = Auth::id();
        $this->user = User::find($this->userId);
    }
    public function getNotificationsByTab($tab, $query = null)
    {
        $query = $query ?? $this->user->receivedNotifications();
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

        return $query->orderByDesc('notifications.created_at')->paginate(5)->appends(['tab' => $tab]);
    }

    public function getUserNotifications($userId, $userAssociation = null)
    {
        $userRoles = $this->userService->getUsersRoles($userId);
        $audiences = array_merge(['all', $userAssociation], $userRoles);

        return $this->user->receivedNotifications()
            ->when(!empty($audiences), function ($q) use ($audiences) {
                $q->whereIn('recipient_group', $audiences);
            });
    }

    public function getUserUnreadNotif($userId)
    {
        $user = User::find($userId);
        return $user->receivedNotifications()
            ->wherePivot('read_at', null)
            ->get();
    }

    public function markAllNotificationsAsRead()
    {
        $unreadNotifIds = $this->user->receivedNotifications()->wherePivot('read_at', null)->pluck('notifications.id');
        $this->user->receivedNotifications()
            ->updateExistingPivot($unreadNotifIds, ['read_at' => now()]);
    }
}