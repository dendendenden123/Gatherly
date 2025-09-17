@extends('layouts.admin')
@section('styles')
<link href="{{ asset('css/admin/notifications/index.css') }}" rel="stylesheet">
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
            <button type="submit" class="btn btn-outline">
                <i class="fas fa-check-circle"></i> Mark All Read
            </button>
        </form>
        <button class="btn btn-primary" id="newNotificationBtn" type="button">
            <i class="fas fa-plus"></i> New Notification
        </button>
    </div>
</div>

@endSection


@section('content')
    <!-- Main Content -->
    <div class="compose-panel" id="composePanel" style="display:none;">
        <div class="compose-header">
            <div class="compose-title">Compose New Notification</div>
            <button id="closeCompose" type="button">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="notificationForm" method="POST" action="{{ route('admin.notifications.store') }}">
            @csrf
            <div class="form-group">
                <label for="notificationType">Notification Type</label>
                <select id="notificationType" name="type" required>
                    <option value="">Select type...</option>
                    <option value="email">Email</option>
                    <option value="sms">Text Message</option>
                    <option value="app">In-App Notification</option>
                    <option value="all">All Channels</option>
                </select>
            </div>

            <div class="form-group">
                <label for="recipients">Recipients (optional)</label>
                <input type="text" id="recipients" name="recipients" placeholder="e.g. all, active, volunteers">
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category">
                    <option value="announcement">General Announcement</option>
                    <option value="event">Event Reminder</option>
                    <option value="urgent">Urgent Alert</option>
                    <option value="spiritual">Spiritual Message</option>
                    <option value="volunteer">Volunteer Request</option>
                </select>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" placeholder="Enter subject..." required>
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Type your message here..." required></textarea>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" id="scheduleCheckbox"> Schedule for later
                </label>
                <input type="datetime-local" id="scheduleTime" name="scheduled_at" style="display: none; margin-top: 5px;">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Send Notification
            </button>
        </form>
    </div>

    <!-- Notification Tabs -->
    <div class="notification-tabs">
        <a href="{{ route('admin.notifications.index') }}" class="tab {{ request('filter') ? '' : 'active' }}"
            data-tab="all">All Notifications</a>
        <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}"
            class="tab {{ request('filter') === 'unread' ? 'active' : '' }}" data-tab="unread">Unread <span
                class="tab-badge">{{ $unreadCount ?? 0 }}</span></a>
        <a href="{{ route('admin.notifications.index', ['filter' => 'alerts']) }}"
            class="tab {{ request('filter') === 'alerts' ? 'active' : '' }}" data-tab="alerts">Alerts</a>
        <a href="{{ route('admin.notifications.index', ['filter' => 'announcements']) }}"
            class="tab {{ request('filter') === 'announcements' ? 'active' : '' }}"
            data-tab="announcements">Announcements</a>
    </div>

    <!-- Notification List -->
    <div class="notification-list">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @forelse($notifications as $n)
            <div class="notification-item {{ $n->is_read ? '' : 'unread' }}">
                <div class="notification-icon">
                    @php
                        $icon = 'fa-bell';
                        if ($n->category === 'urgent') {
                            $icon = 'fa-exclamation-circle';
                        } elseif ($n->category === 'event') {
                            $icon = 'fa-calendar-alt';
                        } elseif ($n->category === 'volunteer') {
                            $icon = 'fa-hands-helping';
                        } elseif ($n->category === 'spiritual') {
                            $icon = 'fa-praying-hands';
                        }
                    @endphp
                    <i class="fas {{ $icon }}"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">
                        <span>{{ $n->subject }}</span>
                        <span class="notification-time">{{ optional($n->created_at)->format('M d, h:i A') }}</span>
                    </div>
                    <div class="notification-message">{{ $n->message }}</div>
                    <div class="notification-actions">
                        @if(!$n->is_read)
                            <form action="{{ route('admin.notifications.read', $n->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                <button type="submit" class="action-link" style="background:none;border:none;">
                                    <i class="fas fa-check"></i> Mark Read
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.notifications.destroy', $n->id) }}" method="POST"
                            style="display:inline-block;" onsubmit="return confirm('Delete this notification?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-link" style="background:none;border:none;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>No notifications found.</p>
        @endforelse

        <div style="margin-top: 10px;">
            {{ $notifications->withQueryString()->links() }}
        </div>
    </div>

@endsection

<script>
    // Mobile menu toggle
    document.getElementById('menuToggle').addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('active');
    });

    // New Notification Button
    document.getElementById('newNotificationBtn').addEventListener('click', function () {
        document.getElementById('composePanel').classList.add('active');
    });

    // Close Compose Panel
    document.getElementById('closeCompose').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('composePanel').classList.remove('active');
    });

    // (Removed) Mark All as Read handled by form submit above

    // Tab Switching
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelector('.tab.active').classList.remove('active');
            this.classList.add('active');
            // In a real app, this would filter notifications
        });
    });

    // Schedule Checkbox Toggle
    document.getElementById('scheduleCheckbox').addEventListener('change', function () {
        const scheduleTime = document.getElementById('scheduleTime');
        scheduleTime.style.display = this.checked ? 'block' : 'none';
    });

    // Simplified recipients: plain text input, no tag UI

    // On successful submit, server redirects back with flash; no JS interception
</script>