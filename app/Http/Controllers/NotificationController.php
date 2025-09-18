<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');
        $query = Notification::query();
        switch ($tab) {
            case 'unread':
                $query->where('is_read', false);
                break;
            case 'alerts':
                $query->where('category', 'alerts');
                break;
            case 'announcements':
                $query->where('category', 'announcements');
                break;
            default:
                // all
                break;
        }
        $notifications = $query->latest()->paginate(15)->appends(['tab' => $tab]);
        $unreadCount = Notification::where('is_read', false)->count();
        return view('admin.notifications.index', compact('notifications', 'unreadCount', 'tab'));
    }

    public function create()
    {
        return view('admin.notifications.create');
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
            'recipient_group' => $validated['recipients'] ?? null,
            'sender_id' => Auth::user()->id,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'category' => $validated['category'] ?? null,

        ]);

        return back()->with('success', 'Notification queued/sent successfully');
    }

    public function markAllRead()
    {
        Notification::where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
        return back()->with('success', 'All notifications marked as read');
    }

    public function markRead(Notification $notification)
    {
        if (!$notification->is_read) {
            $notification->is_read = true;
            $notification->read_at = now();
            $notification->save();
        }
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
}
