<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatherly - Create Notification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-green: #2ecc71;
            --dark-green: #27ae60;
            --accent-red: #e74c3c;
            --light-gray: #f5f5f5;
            --medium-gray: #ecf0f1;
            --dark-gray: #95a5a6;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --purple: #9b59b6;
            --blue: #3498db;
            --orange: #e67e22;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: var(--light-gray);
            color: var(--text-dark);
        }

        /* Mobile Header */
        .mobile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .mobile-menu-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-dark);
            cursor: pointer;
        }

        .mobile-logo {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary-green);
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px 0;
            display: none;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 99;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .sidebar.active {
            transform: translateX(0);
            display: flex;
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            padding: 20px;
            margin-top: 65px;
        }

        /* Notification Creation Header */
        .create-header {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        @media (min-width: 768px) {
            .create-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .create-title h1 {
            font-size: 1.5rem;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .create-title p {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* Notification Creation Form */
        .creation-form {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .form-section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .channel-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        @media (min-width: 768px) {
            .channel-options {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .channel-option {
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .channel-option:hover {
            border-color: var(--primary-green);
        }

        .channel-option.selected {
            border-color: var(--primary-green);
            background-color: rgba(46, 204, 113, 0.05);
        }

        .channel-option i {
            font-size: 1.5rem;
            margin-bottom: 5px;
            display: block;
        }

        .channel-option .channel-name {
            font-weight: 500;
        }

        .channel-option .channel-desc {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .recipient-selection {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .recipient-tag {
            background-color: var(--medium-gray);
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .tag-remove {
            cursor: pointer;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid var(--medium-gray);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background-color: var(--primary-green);
            color: white;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-green);
            color: var(--primary-green);
        }

        /* Preview Section */
        .preview-section {
            background-color: var(--light-gray);
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }

        .preview-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .preview-card {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .preview-subject {
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .preview-message {
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .preview-meta {
            font-size: 0.8rem;
            color: var(--text-light);
            border-top: 1px solid var(--medium-gray);
            padding-top: 10px;
        }

        /* Responsive Adjustments */
        @media (min-width: 768px) {
            .mobile-header {
                display: none;
            }

            .sidebar {
                display: flex;
                position: relative;
                transform: translateX(0);
                height: auto;
            }

            .main-content {
                margin-top: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Mobile Header -->
    <div class="mobile-header">
        <button class="mobile-menu-btn" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="mobile-logo">Gatherly</div>
        <div class="mobile-user-avatar"></div>
    </div>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h2>Gatherly</h2>
            <span>Church Management System</span>
        </div>

        <div class="nav-menu">
            <div class="nav-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-users"></i>
                <span>Members</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-calendar-check"></i>
                <span>Attendance</span>
            </div>
            <div class="nav-item">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </div>
            <div class="nav-item active">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Creation Header -->
        <div class="create-header">
            <div class="create-title">
                <h1>Create New Notification</h1>
                <p>Send messages to your church members</p>
            </div>
        </div>

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
    </div>

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
</body>

</html>