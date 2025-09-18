@extends('layouts.admin')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href={{ asset('css/admin/notifications/create.css') }}>
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
    <form id="notificationForm" method="POST" action="{{ route('admin.notifications.store') }}" class="creation-form">
        @csrf
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                });
            </script>
        @elseif(session('error'))
            <script>
                Swal.fire({
                    icon: 'Error',
                    title: 'Failed!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d63030ff',
                });
            </script>
        @endif
        <!-- Basic Info Section -->
        <div class="form-section">
            <div class="section-title">Notification Details</div>

            <div class="form-group">
                <label for="notificationSubject">Subject *</label>
                <input type="text" id="notificationSubject" name="subject" placeholder="Enter notification subject..."
                    required>
            </div>

            <div class="form-group">
                <label for="notificationMessage">Message *</label>
                <textarea id="notificationMessage" name="message" placeholder="Type your message here..."
                    required></textarea>
            </div>

            <div class="form-group">
                <label for="notificationCategory">Category</label>
                <select id="notificationCategory" name="category">
                    <option value="announcement">General Announcement</option>
                    <option value="event">Event Reminder</option>
                    <option value="urgent">Urgent Alert</option>
                    <option value="spiritual">Spiritual Message</option>
                    <option value="volunteer">Volunteer Request</option>
                </select>
            </div>
        </div>

        <!-- Recipients Section -->
        <div class="form-section">
            <div class="section-title">Recipients</div>

            <div class="form-group">
                <label for="recipientType">Send To *</label>
                <select id="recipientType" name="recipient_group" required>
                    <option value="">Select recipient group...</option>
                    <option value="all">All Members</option>
                    <option value="active">Active Members Only</option>
                    <option value="inactive">Inactive Members</option>
                    <option value="visitors">Recent Visitors</option>
                    <option value="volunteers">All Volunteers</option>
                    <option value="small_groups">Small Groups</option>
                </select>
            </div>

            <!-- Dynamic recipient selection (shown when Small Groups or Custom selected) -->
            <div class="form-group" id="groupSelection" style="display: none;">
                <label>Select Groups</label>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="category" value="mens_group"> Men's Bible Study
                    </label>
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="category" value="womens_group"> Women's Fellowship
                    </label>
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="category" value="youth_group"> Youth Group
                    </label>
                    <label style="display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="category" value="seniors_group"> Seniors Ministry
                    </label>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="button" class="btn btn-outline" id="previewBtn"
                data-loggedUser="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}">

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
                <div id="sender">From: Pastor John Smith</div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 15px;">
            <button class="btn btn-outline" id="closePreview">
                <i class="fas fa-times"></i> Close Preview
            </button>
        </div>
    </div>
    @vite('resources/js/admin-notification-create.js')
@endsection