<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatherly - Notifications</title>
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

        /* Notifications Header */
        .notifications-header {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        @media (min-width: 768px) {
            .notifications-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .notifications-title h1 {
            font-size: 1.5rem;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .notifications-title p {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .notifications-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        @media (min-width: 768px) {
            .notifications-actions {
                margin-top: 0;
            }
        }

        .btn {
            padding: 8px 15px;
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

        /* Notification Tabs */
        .notification-tabs {
            display: flex;
            border-bottom: 1px solid var(--medium-gray);
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 15px;
            cursor: pointer;
            position: relative;
            font-weight: 500;
        }

        .tab.active {
            color: var(--primary-green);
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary-green);
        }

        .tab-badge {
            margin-left: 5px;
            background-color: var(--accent-red);
            color: white;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 0.7rem;
        }

        /* Notification List */
        .notification-list {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .notification-item {
            display: flex;
            padding: 15px;
            border-bottom: 1px solid var(--medium-gray);
            transition: background-color 0.2s;
        }

        .notification-item:hover {
            background-color: var(--light-gray);
        }

        .notification-item.unread {
            background-color: rgba(46, 204, 113, 0.05);
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--medium-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .notification-icon i {
            color: var(--primary-green);
        }

        .notification-content {
            flex-grow: 1;
        }

        .notification-title {
            font-weight: 500;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
        }

        .notification-time {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .notification-message {
            font-size: 0.9rem;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .notification-actions {
            display: flex;
            gap: 10px;
        }

        .action-link {
            font-size: 0.8rem;
            color: var(--primary-green);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .notification-checkbox {
            margin-right: 15px;
            display: flex;
            align-items: center;
        }

        /* Compose Notification Panel */
        .compose-panel {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            display: none;
        }

        .compose-panel.active {
            display: block;
        }

        .compose-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .compose-title {
            font-size: 1.1rem;
            font-weight: 600;
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
            min-height: 100px;
            resize: vertical;
        }

        .recipient-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 5px;
        }

        .tag {
            background-color: var(--medium-gray);
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .tag-remove {
            cursor: pointer;
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
        <!-- Notifications Header -->
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

        <!-- Compose Notification Panel (Hidden by Default) -->
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
    </div>

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
</body>

</html>