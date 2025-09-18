@extends('layouts.admin')
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href={{ asset('css/admin/notifications/index.css') }}>
@endSection

@section('header')
<div class="notifications-header">
    <div class="notifications-title">
        <h1>Notifications Center</h1>
        <p>Manage communications with your congregation</p>
    </div>

    <div class="notifications-actions">
        <form action="{{ route('admin.notifications.markAllRead') }}" method="POST" style="display:inline-block;">
            @csrf
            <button type="submit" class="btn btn-outline" id="markAllReadBtn">
                <i class="fas fa-check-circle"></i> Mark All Read
            </button>
        </form>
        <a href="{{ route('admin.notifications.create') }}" class="text-reset text-decoration-none">
            <button class="btn btn-primary" id="newNotificationBtn">
                <i class="fas fa-plus"></i> New Notification
            </button>
        </a>
    </div>
</div>

@endSection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Notification Tabs -->
    <div class="notification-tabs">
        <a href="{{ route('admin.notifications.index', ['tab' => 'all']) }}"
            class="tab {{ ($tab ?? 'all') === 'all' ? 'active' : '' }}" data-tab="all">All Notifications</a>
        <a href="{{ route('admin.notifications.index', ['tab' => 'unread']) }}"
            class="tab {{ ($tab ?? '') === 'unread' ? 'active' : '' }}" data-tab="unread">Unread <span
                class="tab-badge">{{ $unreadCount ?? 0 }}</span></a>
        <a href="{{ route('admin.notifications.index', ['tab' => 'alerts']) }}"
            class="tab {{ ($tab ?? '') === 'alerts' ? 'active' : '' }}" data-tab="alerts">Alerts</a>
        <a href="{{ route('admin.notifications.index', ['tab' => 'announcements']) }}"
            class="tab {{ ($tab ?? '') === 'announcements' ? 'active' : '' }}" data-tab="announcements">Announcements</a>
    </div>

    <!-- Notification List -->
    <form action="{{ route('admin.notifications.bulkDestroy') }}" method="POST" id="bulkForm">
        @csrf
        @method('DELETE')
        <div class="notification-list">
            @forelse ($notifications as $notification)
                @php
                    $when = $notification->sent_at ?? $notification->scheduled_at ?? $notification->created_at;
                    $icon = 'fa-bell';
                    if ($notification->category === 'alerts') {
                        $icon = 'fa-exclamation-circle';
                    } elseif ($notification->category === 'announcements') {
                        $icon = 'fa-calendar-alt';
                    } elseif ($notification->category === 'system') {
                        $icon = 'fa-cog';
                    }
                @endphp
                <div class="notification-item {{ $notification->is_read ? '' : 'unread' }}">
                    <div class="notification-checkbox">
                        <input type="checkbox" name="ids[]" value="{{ $notification->id }}">
                    </div>
                    <div class="notification-icon">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">
                            <span>{{ $notification->subject }}</span>
                            <span class="notification-time">{{ $when?->diffForHumans() }}</span>
                        </div>
                        <div class="notification-message">
                            {{ Str::limit($notification->message, 160) }}
                        </div>
                        <div class="notification-actions">
                            @if (!$notification->is_read)
                                <form action="{{ route('admin.notifications.markRead', $notification) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="action-link"
                                        style="background:none;border:0;padding:0;color:inherit;">
                                        <i class="fas fa-eye"></i> Mark Read
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-link"
                                    style="background:none;border:0;padding:0;color:inherit;">
                                    <i class="fas fa-archive"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="notification-item">
                    <div class="notification-content">
                        <div class="notification-title">
                            <span>No notifications</span>
                        </div>
                        <div class="notification-message">Create a new notification to get started.</div>
                    </div>
                </div>
            @endforelse
        </div>
        <div style="margin-top:12px; display:flex; gap:8px; align-items:center;">
            <button type="submit" class="btn btn-outline" id="bulkDeleteBtn">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
            <div style="margin-left:auto;">
                {{ $notifications->links() }}
            </div>
        </div>
    </form>
    @vite("resources/js/admin-notification-index.js")
@endsection