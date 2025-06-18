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
        <button class="btn btn-outline" id="markAllReadBtn">
            <i class="fas fa-check-circle"></i> Mark All Read
        </button>
        <a href="{{ route('admin.notifications.create') }}" class="text-reset text-decoration-none">
            <button class="btn btn-primary" id="newNotificationBtn">
                <i class="fas fa-plus"></i> New Notification
            </button>
        </a>
    </div>
</div>

@endSection


@section('content')
    <!-- Main Content -->
    <div class="compose-panel" id="composePanel">
        <div class="compose-header">
            <div class="compose-title">Compose New Notification</div>
            <button id="closeCompose">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="notificationForm">
            <div class="form-group">
                <label for="notificationType">Notification Type</label>
                <select id="notificationType" required>
                    <option value="">Select type...</option>
                    <option value="email">Email</option>
                    <option value="sms">Text Message</option>
                    <option value="app">In-App Notification</option>
                    <option value="all">All Channels</option>
                </select>
            </div>

            <div class="form-group">
                <label for="recipients">Recipients</label>
                <select id="recipients" multiple>
                    <option value="all">All Members</option>
                    <option value="active">Active Members Only</option>
                    <option value="volunteers">Volunteers</option>
                    <option value="small_group1">Small Group: Men's Bible Study</option>
                    <option value="small_group2">Small Group: Women's Fellowship</option>
                    <option value="youth">Youth Group</option>
                </select>
                <div class="recipient-tags" id="recipientTags"></div>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" placeholder="Enter subject..." required>
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" placeholder="Type your message here..." required></textarea>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" id="scheduleCheckbox"> Schedule for later
                </label>
                <input type="datetime-local" id="scheduleTime" style="display: none; margin-top: 5px;">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Send Notification
            </button>
        </form>
    </div>

    <!-- Notification Tabs -->
    <div class="notification-tabs">
        <div class="tab active" data-tab="all">All Notifications</div>
        <div class="tab" data-tab="unread">Unread <span class="tab-badge">5</span></div>
        <div class="tab" data-tab="alerts">Alerts</div>
        <div class="tab" data-tab="announcements">Announcements</div>
    </div>

    <!-- Notification List -->
    <div class="notification-list">
        <!-- Unread Notification Example -->
        <div class="notification-item unread">
            <div class="notification-checkbox">
                <input type="checkbox">
            </div>
            <div class="notification-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="notification-content">
                <div class="notification-title">
                    <span>Volunteers Needed for Food Drive</span>
                    <span class="notification-time">Today, 10:30 AM</span>
                </div>
                <div class="notification-message">
                    We need 5 more volunteers for this Saturday's community food drive. Please sign up if available.
                </div>
                <div class="notification-actions">
                    <a href="#" class="action-link">
                        <i class="fas fa-reply"></i> Reply
                    </a>
                    <a href="#" class="action-link">
                        <i class="fas fa-archive"></i> Archive
                    </a>
                </div>
            </div>
        </div>

        <!-- Read Notification Example -->
        <div class="notification-item">
            <div class="notification-checkbox">
                <input type="checkbox">
            </div>
            <div class="notification-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="notification-content">
                <div class="notification-title">
                    <span>Upcoming Baptism Service</span>
                    <span class="notification-time">Yesterday, 3:45 PM</span>
                </div>
                <div class="notification-message">
                    Reminder: Baptism service this Sunday after morning worship. Please arrive by 12:30 PM if
                    participating.
                </div>
                <div class="notification-actions">
                    <a href="#" class="action-link">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                    <a href="#" class="action-link">
                        <i class="fas fa-archive"></i> Archive
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Notification Example -->
        <div class="notification-item unread">
            <div class="notification-checkbox">
                <input type="checkbox">
            </div>
            <div class="notification-icon">
                <i class="fas fa-urgent"></i>
            </div>
            <div class="notification-content">
                <div class="notification-title">
                    <span>Weather Alert: Service Cancellation</span>
                    <span class="notification-time">Jun 24, 8:15 AM</span>
                </div>
                <div class="notification-message">
                    Due to severe weather warnings, tonight's Bible study has been cancelled. Stay safe!
                </div>
                <div class="notification-actions">
                    <a href="#" class="action-link">
                        <i class="fas fa-share"></i> Forward
                    </a>
                    <a href="#" class="action-link">
                        <i class="fas fa-archive"></i> Archive
                    </a>
                </div>
            </div>
        </div>

        <!-- System Notification Example -->
        <div class="notification-item">
            <div class="notification-checkbox">
                <input type="checkbox">
            </div>
            <div class="notification-icon">
                <i class="fas fa-cog"></i>
            </div>
            <div class="notification-content">
                <div class="notification-title">
                    <span>System Update Completed</span>
                    <span class="notification-time">Jun 23, 11:20 PM</span>
                </div>
                <div class="notification-message">
                    The latest Gatherly update has been installed. New features include improved attendance
                    tracking.
                </div>
                <div class="notification-actions">
                    <a href="#" class="action-link">
                        <i class="fas fa-info-circle"></i> Learn More
                    </a>
                </div>
            </div>
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

    // Mark All as Read
    document.getElementById('markAllReadBtn').addEventListener('click', function () {
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
        });
        alert('All notifications marked as read');
    });

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

    // Recipient Selection
    document.getElementById('recipients').addEventListener('change', function () {
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
    });

    // Remove recipient tag
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('tag-remove')) {
            const value = e.target.getAttribute('data-value');
            const option = document.querySelector(`#recipients option[value="${value}"]`);
            option.selected = false;
            e.target.parentElement.remove();
        }
    });

    // Form Submission
    document.getElementById('notificationForm').addEventListener('submit', function (e) {
        e.preventDefault();
        alert('Notification sent successfully!');
        this.reset();
        document.getElementById('recipientTags').innerHTML = '';
        document.getElementById('composePanel').classList.remove('active');
    });
</script>