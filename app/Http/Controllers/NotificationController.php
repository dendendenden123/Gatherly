<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate(15);
        $unreadCount = Notification::where('is_read', false)->count();
        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:email,sms,app,all',
            'recipients' => 'nullable|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'category' => 'nullable|string|max:100',
            'schedule' => 'nullable|boolean',
            'schedule_time' => 'nullable|date',
        ]);

        $scheduledAt = null;
        if ($request->boolean('schedule') && $request->filled('schedule_time')) {
            $scheduledAt = new \DateTime($request->input('schedule_time'));
        }

        Notification::create([
            'type' => $validated['type'],
            'recipient_group' => $validated['recipients'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'category' => $validated['category'] ?? null,
            'scheduled_at' => $scheduledAt,
            'sent_at' => $scheduledAt ? null : now(),
        ]);

        return redirect()->route('admin.notifications.index')->with('success', 'Notification queued/sent successfully');
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
