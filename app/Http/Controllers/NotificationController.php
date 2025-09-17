<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $query = Notification::query()->orderByDesc('id');
        if ($filter === 'unread') {
            $query->where('is_read', false);
        }
        if ($filter === 'alerts') {
            $query->where('category', 'urgent');
        }
        if ($filter === 'announcements') {
            $query->where('category', 'announcement');
        }
        $notifications = $query->simplePaginate(10);
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
            'recipients' => 'nullable',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'category' => 'nullable|string|max:50',
            'scheduled_at' => 'nullable|date',
        ]);

        Notification::create([
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'category' => $validated['category'] ?? null,
            'scheduled_at' => $validated['scheduled_at'] ?? null,
            'is_read' => false,
        ]);

        return back()->with('success', 'Notification queued/created successfully.');
    }

    public function markRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);
        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        return back()->with('success', 'Notification deleted.');
    }
}
