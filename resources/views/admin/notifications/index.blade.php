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
    <!-- Main Content -->
    <div class="compose-panel" id="composePanel">
        <div class="compose-header">
            <div class="compose-title">Compose New Notification</div>
            <button id="closeCompose">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="notificationForm" action="{{ route('admin.notifications.store') }}" method="POST">
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
                <label for="recipients">Recipients</label>
                <select id="recipientsSelect" multiple>
                    <option value="all">All Members</option>
                    <option value="active">Active Members Only</option>
                    <option value="volunteers">Volunteers</option>
                    <option value="small_group1">Small Group: Men's Bible Study</option>
                    <option value="small_group2">Small Group: Women's Fellowship</option>
                    <option value="youth">Youth Group</option>
                </select>
                <input type="hidden" name="recipients" id="recipientsInput" />
                <div class="recipient-tags" id="recipientTags"></div>
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
                <label for="category">Category</label>
                <select id="category" name="category">
                    <option value="">None</option>
                    <option value="alerts">Alerts</option>
                    <option value="announcements">Announcements</option>
                    <option value="system">System</option>
                </select>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" id="scheduleCheckbox" name="schedule" value="1"> Schedule for later
                </label>
                <input type="datetime-local" id="scheduleTime" name="schedule_time" style="display: none; margin-top: 5px;">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Send Notification
            </button>
        </form>
    </div>

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

    // Mark All as Read now handled by form POST

    // Tab Switching is now handled by anchor links

    // Schedule Checkbox Toggle
    document.getElementById('scheduleCheckbox').addEventListener('change', function () {
        const scheduleTime = document.getElementById('scheduleTime');
        scheduleTime.style.display = this.checked ? 'block' : 'none';
    });

    // Recipient Selection
    document.getElementById('recipientsSelect').addEventListener('change', function () {
        const tagsContainer = document.getElementById('recipientTags');
        tagsContainer.innerHTML = '';

        Array.from(this.selectedOptions).forEach(option => {
            const tag = document.createElement('div');
            tag.className = 'tag';
            tag.innerHTML = `
                    ${option.text}
                    <span class="tag-remove" data-value="${option.value}">×</span>
                `;
            tagsContainer.appendChild(tag);
        });

        // update hidden recipients input as comma-separated list
        const values = Array.from(this.selectedOptions).map(o => o.value);
        document.getElementById('recipientsInput').value = values.join(',');
    });

    // Remove recipient tag
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('tag-remove')) {
            const value = e.target.getAttribute('data-value');
            const option = document.querySelector(`#recipientsSelect option[value="${value}"]`);
            option.selected = false;
            e.target.parentElement.remove();
            const select = document.getElementById('recipientsSelect');
            const values = Array.from(select.selectedOptions).map(o => o.value);
            document.getElementById('recipientsInput').value = values.join(',');
        }
    });

    // Form Submission: prevent double submit, show loading
    document.getElementById('notificationForm').addEventListener('submit', function (e) {
        const select = document.getElementById('recipientsSelect');
        const values = Array.from(select.selectedOptions).map(o => o.value);
        document.getElementById('recipientsInput').value = values.join(',');
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    });

    // Bulk delete confirmation
    document.getElementById('bulkForm').addEventListener('submit', function (e) {
        if (!confirm('Are you sure you want to delete the selected notifications?')) {
            e.preventDefault();
        }
    });
</script>