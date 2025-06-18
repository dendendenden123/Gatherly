@extends('layouts.admin')
@section('styles')
    <link href="{{ asset('css/admin/notifications/create.css') }}" rel="stylesheet">
@endsection

@section('header')
    <!-- Creation Header -->
    <div class="create-header">
        <div class="create-title">
            <h1>Create New Notification</h1>
            <p>Send messages to your church members</p>
        </div>
    </div>
@endsection

@section('content')

    <!-- Main Content -->
    <!-- Notification Creation Form -->
    <form id="notificationForm" class="creation-form">
        <!-- Basic Info Section -->
        <div class="form-section">
            <div class="section-title">Notification Details</div>

            <div class="form-group">
                <label for="notificationSubject">Subject *</label>
                <input type="text" id="notificationSubject" placeholder="Enter notification subject..." required>
            </div>

            <div class="form-group">
                <label for="notificationMessage">Message *</label>
                <textarea id="notificationMessage" placeholder="Type your message here..." required></textarea>
            </div>

            <div class="form-group">
                <label for="notificationCategory">Category</label>
                <select id="notificationCategory">
                    <option value="announcement">General Announcement</option>
                    <option value="event">Event Reminder</option>
                    <option value="urgent">Urgent Alert</option>
                    <option value="spiritual">Spiritual Message</option>
                    <option value="volunteer">Volunteer Request</option>
                </select>
            </div>
        </div>

        <!-- Delivery Channels Section -->
        <div class="form-section">
            <div class="section-title">Delivery Channels</div>
            <p style="margin-bottom: 15px; font-size: 0.9rem; color: var(--text-light);">
                Select how you want this notification to be delivered
            </p>

            <div class="channel-options">
                <div class="channel-option selected" data-channel="email">
                    <i class="fas fa-envelope"></i>
                    <div class="channel-name">Email</div>
                    <div class="channel-desc">Send as email</div>
                </div>

                <div class="channel-option" data-channel="sms">
                    <i class="fas fa-sms"></i>
                    <div class="channel-name">Text Message</div>
                    <div class="channel-desc">SMS notification</div>
                </div>

                <div class="channel-option selected" data-channel="app">
                    <i class="fas fa-mobile-alt"></i>
                    <div class="channel-name">In-App</div>
                    <div class="channel-desc">Gatherly app</div>
                </div>

                <div class="channel-option" data-channel="push">
                    <i class="fas fa-bell"></i>
                    <div class="channel-name">Push Notification</div>
                    <div class="channel-desc">Mobile alerts</div>
                </div>
            </div>
        </div>

        <!-- Recipients Section -->
        <div class="form-section">
            <div class="section-title">Recipients</div>

            <div class="form-group">
                <label for="recipientType">Send To *</label>
                <select id="recipientType" required>
                    <option value="">Select recipient group...</option>
                    <option value="all">All Members</option>
                    <option value="active">Active Members Only</option>
                    <option value="inactive">Inactive Members</option>
                    <option value="visitors">Recent Visitors</option>
                    <option value="volunteers">All Volunteers</option>
                    <option value="small_groups">Small Groups</option>
                    <option value="custom">Custom Selection</option>
                </select>
            </div>

            <!-- Dynamic recipient selection (shown when Small Groups or Custom selected) -->
            <div class="form-group" id="groupSelection" style="display: none;">
                <label>Select Groups</label>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="groups" value="mens_group"> Men's Bible Study
                    </label>
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="groups" value="womens_group"> Women's Fellowship
                    </label>
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="groups" value="youth_group"> Youth Group
                    </label>
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="groups" value="seniors_group"> Seniors Ministry
                    </label>
                </div>
            </div>

            <div class="form-group" id="customSelection" style="display: none;">
                <label>Select Individual Members</label>
                <input type="text" placeholder="Search members..." style="margin-bottom: 10px;">
                <div class="recipient-selection" id="selectedRecipients"></div>
            </div>
        </div>

        <!-- Scheduling Section -->
        <div class="form-section">
            <div class="section-title">Scheduling</div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px;">
                    <input type="radio" name="scheduleType" value="now" checked> Send Immediately
                </label>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px;">
                    <input type="radio" name="scheduleType" value="later"> Schedule for Later
                </label>
                <div id="scheduleFields" style="display: none; margin-top: 10px;">
                    <input type="datetime-local" id="scheduleTime" style="width: 100%;">
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="button" class="btn btn-outline" id="previewBtn">
                <i class="fas fa-eye"></i> Preview
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Send Notification
            </button>
        </div>
    </form>

    <!-- Preview Section (Initially Hidden) -->
    <div class="preview-section" id="previewSection" style="display: none;">
        <div class="preview-title">Notification Preview</div>
        <div class="preview-card">
            <div class="preview-subject" id="previewSubject">Sample Subject</div>
            <div class="preview-message" id="previewMessage">
                This is a preview of how your notification will appear to recipients.
            </div>
            <div class="preview-meta">
                <div>From: Pastor John Smith</div>
                <div>Sent via: Email & In-App</div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 15px;">
            <button class="btn btn-outline" id="closePreview">
                <i class="fas fa-times"></i> Close Preview
            </button>
        </div>
    </div>
@endsection

<script>
    // Mobile menu toggle
    document.getElementById('menuToggle').addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('active');
    });

    // Channel Selection
    document.querySelectorAll('.channel-option').forEach(option => {
        option.addEventListener('click', function () {
            this.classList.toggle('selected');
        });
    });

    // Recipient Type Selection
    document.getElementById('recipientType').addEventListener('change', function () {
        const groupSelection = document.getElementById('groupSelection');
        const customSelection = document.getElementById('customSelection');

        groupSelection.style.display = 'none';
        customSelection.style.display = 'none';

        if (this.value === 'small_groups') {
            groupSelection.style.display = 'block';
        } else if (this.value === 'custom') {
            customSelection.style.display = 'block';
        }
    });

    // Schedule Type Selection
    document.querySelectorAll('input[name="scheduleType"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.getElementById('scheduleFields').style.display =
                this.value === 'later' ? 'block' : 'none';
        });
    });

    // Preview Button
    document.getElementById('previewBtn').addEventListener('click', function () {
        const subject = document.getElementById('notificationSubject').value || 'Sample Subject';
        const message = document.getElementById('notificationMessage').value ||
            'This is a preview of how your notification will appear to recipients.';

        document.getElementById('previewSubject').textContent = subject;
        document.getElementById('previewMessage').textContent = message;

        document.getElementById('previewSection').style.display = 'block';
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    });

    // Close Preview
    document.getElementById('closePreview').addEventListener('click', function () {
        document.getElementById('previewSection').style.display = 'none';
    });

    // Form Submission
    document.getElementById('notificationForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Get form data
        const subject = document.getElementById('notificationSubject').value;
        const message = document.getElementById('notificationMessage').value;
        const category = document.getElementById('notificationCategory').value;
        const recipientType = document.getElementById('recipientType').value;

        // Get selected channels
        const channels = Array.from(document.querySelectorAll('.channel-option.selected'))
            .map(el => el.getAttribute('data-channel'));

        // Get scheduling info
        const scheduleType = document.querySelector('input[name="scheduleType"]:checked').value;
        const scheduleTime = scheduleType === 'later'
            ? document.getElementById('scheduleTime').value
            : null;

        // In a real app, this would send data to the server
        alert(`Notification scheduled to send to ${recipientType} via ${channels.join(', ')}`);

        // Reset form
        this.reset();
        document.querySelector('.channel-option').classList.add('selected');
        document.querySelectorAll('.channel-option:not(:first-child)').forEach(el => {
            el.classList.remove('selected');
        });
    });

    // In a full implementation, you would add:
    // 1. Member search functionality for custom selection
    // 2. Validation for all required fields
    // 3. API integration to actually send notifications
    // 4. More sophisticated recipient selection
    // 5. Template system for common notifications
</script>