<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public function getNotif($request, $tab)
    {

        $query = Notification::query();
        switch ($tab) {
            case 'unread':
                $query->where('is_read', false);
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
            default:
                // all
                break;
        }

        return $query->latest()->paginate(5)->appends(['tab' => $tab]);
    }
}