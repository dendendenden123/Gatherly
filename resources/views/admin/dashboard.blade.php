@extends('layouts.admin')
@section('content')
    <!-- Dashboard Widgets -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            :root {
                --primary: #4361ee;
                --primary-light: #eef2ff;
                --primary-dark: #3a56d4;
                --secondary: #7209b7;
                --secondary-light: #f3e8fd;
                --accent: #f72585;
                --accent-light: #fde8f1;
                --success: #06d6a0;
                --warning: #ffd166;
                --danger: #ef476f;
                --dark: #1e293b;
                --light: #f8fafc;
                --gray-100: #f1f5f9;
                --gray-200: #e2e8f0;
                --gray-300: #cbd5e1;
                --gray-400: #94a3b8;
                --gray-500: #64748b;
                --gray-600: #475569;
                --gray-700: #334155;
                --gray-800: #1e293b;
                --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                --radius: 12px;
                --radius-sm: 8px;
                --transition: all 0.3s ease;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            }

            body {
                background-color: var(--light);
                color: var(--gray-700);
                line-height: 1.6;
            }

            .dashboard-container {
                max-width: 1400px;
                margin: 0 auto;
                padding: 24px;
            }

            .dashboard-header {
                margin-bottom: 32px;
            }

            .dashboard-header h1 {
                font-size: 28px;
                font-weight: 700;
                color: var(--dark);
                margin-bottom: 8px;
            }

            .dashboard-header p {
                color: var(--gray-500);
                font-size: 16px;
            }

            /* Dashboard Widgets */
            .dashboard-widgets {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 24px;
                margin-bottom: 32px;
            }

            .widget {
                background: white;
                border-radius: var(--radius);
                padding: 24px;
                box-shadow: var(--shadow);
                transition: var(--transition);
                border: 1px solid var(--gray-200);
            }

            .widget:hover {
                box-shadow: var(--shadow-lg);
                transform: translateY(-2px);
            }

            .widget-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 16px;
            }

            .widget-title {
                font-size: 14px;
                font-weight: 600;
                color: var(--gray-600);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .widget-icon {
                height: 48px;
                width: 48px;
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
            }

            .widget-primary .widget-icon {
                background-color: var(--primary-light);
                color: var(--primary);
            }

            .widget-secondary .widget-icon {
                background-color: var(--secondary-light);
                color: var(--secondary);
            }

            .widget-accent .widget-icon {
                background-color: var(--accent-light);
                color: var(--accent);
            }

            .widget-value {
                font-size: 32px;
                font-weight: 700;
                margin-bottom: 8px;
            }

            .widget-primary .widget-value {
                color: var(--primary);
            }

            .widget-secondary .widget-value {
                color: var(--secondary);
            }

            .widget-accent .widget-value {
                color: var(--accent);
            }

            .widget-footer {
                display: flex;
                align-items: center;
                font-size: 13px;
            }

            .widget-footer i {
                margin-right: 4px;
            }

            /* Main Layout */
            .dashboard-main {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 24px;
            }

            @media (max-width: 1024px) {
                .dashboard-main {
                    grid-template-columns: 1fr;
                }
            }

            /* Sections */
            .section {
                background: white;
                border-radius: var(--radius);
                padding: 24px;
                box-shadow: var(--shadow);
                margin-bottom: 24px;
                border: 1px solid var(--gray-200);
            }

            .section-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .section-title {
                font-size: 18px;
                font-weight: 600;
                color: var(--dark);
            }

            .section-actions a {
                color: var(--primary);
                font-size: 14px;
                font-weight: 500;
                text-decoration: none;
                transition: var(--transition);
            }

            .section-actions a:hover {
                color: var(--primary-dark);
            }

            /* Status Cards */
            .status-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 16px;
            }

            .status-card {
                padding: 20px;
                border-radius: var(--radius-sm);
                border-left: 4px solid;
            }

            .status-primary {
                border-left-color: var(--primary);
                background-color: var(--primary-light);
            }

            .status-secondary {
                border-left-color: var(--secondary);
                background-color: var(--secondary-light);
            }

            .status-accent {
                border-left-color: var(--accent);
                background-color: var(--accent-light);
            }

            .status-gray {
                border-left-color: var(--gray-400);
                background-color: var(--gray-100);
            }

            .status-label {
                font-size: 12px;
                text-transform: uppercase;
                font-weight: 600;
                color: var(--gray-600);
                margin-bottom: 8px;
                letter-spacing: 0.5px;
            }

            .status-value {
                font-size: 24px;
                font-weight: 700;
            }

            /* Tables */
            .members-table {
                width: 100%;
                border-collapse: collapse;
            }

            .members-table thead {
                background-color: var(--gray-100);
            }

            .members-table th {
                padding: 12px 16px;
                text-align: left;
                font-size: 12px;
                font-weight: 600;
                color: var(--gray-600);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .members-table td {
                padding: 16px;
                border-bottom: 1px solid var(--gray-200);
            }

            .member-info {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .member-avatar {
                height: 40px;
                width: 40px;
                border-radius: 50%;
                background-color: var(--gray-200);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--gray-500);
                font-weight: 500;
            }

            .member-name {
                font-weight: 500;
                color: var(--dark);
            }

            .member-email {
                font-size: 13px;
                color: var(--gray-500);
            }

            .status-badge {
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
            }

            .status-active {
                background-color: var(--primary-light);
                color: var(--primary);
            }

            .status-inactive {
                background-color: var(--gray-100);
                color: var(--gray-600);
            }

            .status-partial {
                background-color: var(--secondary-light);
                color: var(--secondary);
            }

            .status-expelled {
                background-color: var(--accent-light);
                color: var(--accent);
            }

            .action-btn {
                padding: 6px 12px;
                border-radius: var(--radius-sm);
                font-size: 12px;
                font-weight: 500;
                cursor: pointer;
                transition: var(--transition);
                border: none;
            }

            .edit-btn {
                background-color: var(--primary-light);
                color: var(--primary);
                margin-right: 8px;
            }

            .edit-btn:hover {
                background-color: var(--primary);
                color: white;
            }

            .delete-btn {
                background-color: var(--accent-light);
                color: var(--accent);
            }

            .delete-btn:hover {
                background-color: var(--accent);
                color: white;
            }

            /* Activity List */
            .activity-list {
                list-style: none;
            }

            .activity-item {
                display: flex;
                align-items: flex-start;
                gap: 16px;
                padding: 16px 0;
            }

            .activity-item:not(:last-child) {
                border-bottom: 1px solid var(--gray-200);
            }

            .activity-icon {
                height: 40px;
                width: 40px;
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
                flex-shrink: 0;
            }

            .activity-details h4 {
                font-size: 14px;
                font-weight: 500;
                color: var(--dark);
                margin-bottom: 4px;
            }

            .activity-details p {
                font-size: 13px;
                color: var(--gray-600);
                margin-bottom: 4px;
            }

            .activity-time {
                font-size: 12px;
                color: var(--gray-500);
            }

            /* Quick Actions */
            .quick-actions {
                margin-top: 24px;
            }

            .action-buttons {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 12px;
                margin-top: 16px;
            }

            .action-button {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 12px 16px;
                border-radius: var(--radius-sm);
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                transition: var(--transition);
                border: none;
                color: white;
            }

            .action-button i {
                font-size: 16px;
            }

            .action-primary {
                background-color: var(--primary);
            }

            .action-primary:hover {
                background-color: var(--primary-dark);
            }

            .action-secondary {
                background-color: var(--secondary);
            }

            .action-secondary:hover {
                background-color: #5e08a0;
            }

            .action-accent {
                background-color: var(--accent);
            }

            .action-accent:hover {
                background-color: #e11574;
            }

            /* Chart Container */
            .chart-container {
                height: 200px;
                margin-top: 8px;
            }

            /* Events and Birthdays */
            .event-item,
            .birthday-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 16px 0;
            }

            .event-item:not(:last-child),
            .birthday-item:not(:last-child) {
                border-bottom: 1px solid var(--gray-200);
            }

            .event-icon,
            .birthday-icon {
                height: 40px;
                width: 40px;
                border-radius: var(--radius);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
                flex-shrink: 0;
            }

            .event-icon {
                background-color: var(--primary-light);
                color: var(--primary);
            }

            .birthday-icon {
                background-color: var(--secondary-light);
                color: var(--secondary);
            }

            .event-details h4,
            .birthday-details h4 {
                font-size: 14px;
                font-weight: 500;
                color: var(--dark);
                margin-bottom: 4px;
            }

            .event-details p,
            .birthday-details p {
                font-size: 13px;
                color: var(--gray-600);
            }

            .empty-state {
                text-align: center;
                padding: 32px 16px;
                color: var(--gray-500);
            }

            .empty-state i {
                font-size: 32px;
                margin-bottom: 12px;
                opacity: 0.5;
            }
        </style>
    </head>

    <body>
        <div class="dashboard-container">

            <!-- Dashboard Widgets -->
            <div class="dashboard-widgets">
                <div class="widget widget-primary">
                    <div class="widget-header">
                        <div class="widget-title">Total Members</div>
                        <div class="widget-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="widget-value">{{ $totalMembers }}</div>
                </div>

                <div class="widget widget-accent">
                    <div class="widget-header">
                        <div class="widget-title">Upcoming Events</div>
                        <div class="widget-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    <div class="widget-value">{{ $upcomingEventsCount }}</div>
                    <div class="widget-footer">
                        <span>This week</span>
                    </div>
                </div>

                <div class="widget widget-primary">
                    <div class="widget-header">
                        <div class="widget-title">Volunteers</div>
                        <div class="widget-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                    </div>
                    <div class="widget-value">{{ $volunteersCount }}</div>
                    <div class="widget-footer">
                        <span>Active volunteers</span>
                    </div>
                </div>
            </div>

            <!-- Main Sections -->
            <div class="dashboard-main">
                <div class="left-column">
                    <!-- Member Status Breakdown -->
                    <div class="section">
                        <div class="section-header">
                            <div class="section-title">Member Status Breakdown</div>
                        </div>
                        <div class="status-grid">
                            <div class="status-card status-primary">
                                <div class="status-label">Active</div>
                                <div class="status-value">{{ $activeCount }}</div>
                            </div>
                            <div class="status-card status-gray">
                                <div class="status-label">Inactive</div>
                                <div class="status-value">{{ $inactiveCount }}</div>
                            </div>
                            <div class="status-card status-secondary">
                                <div class="status-label">Partially-Active</div>
                                <div class="status-value">{{ $partiallyActiveCount }}</div>
                            </div>
                            <div class="status-card status-accent">
                                <div class="status-label">Expelled</div>
                                <div class="status-value">{{ $expelledCount }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Members -->
                    <div class="section">
                        <div class="section-header">
                            <div class="section-title">Recent Members</div>
                            <div class="section-actions">
                                <a href="{{ route('admin.members') }}">View All</a>
                            </div>
                        </div>

                        <table class="members-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Join Date</th>
                                    <th>Birthdate</th>
                                    <th>Status</th>
                                    <th>Marital Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentMembers as $member)

                                    <tr>
                                        <td>
                                            <div class="member-info">
                                                <div class="member-avatar">SJ</div>
                                                <div>
                                                    <div class="member-name">{{  $member->first_name }}
                                                        {{  $member->last_name }}
                                                    </div>
                                                    <div class="member-email">{{  $member->email }} </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{  $member->created_at->format('M d, Y') }}</td>
                                        <td>{{  $member->birthdate->format('M d, Y') }}</td>
                                        <td>
                                            <span
                                                class="status-badge status-{{   $member->status }}">{{  $member->status }}</span>
                                        </td>

                                        <td>{{  $member->marital_status}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Recent Activity & Quick Actions -->
                    <div class="section">
                        <div class="section-header">
                            <div class="section-title">Recent Activity</div>
                            <div class="section-actions">
                                <a href="#">View All</a>
                            </div>
                        </div>

                        <ul class="activity-list">
                            <li class="activity-item">
                                <div class="activity-icon"
                                    style="background-color: var(--primary-light); color: var(--primary);">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="activity-details">
                                    <h4>New Member Added</h4>
                                    <p>Sarah Johnson joined the church</p>
                                    <div class="activity-time">2 hours ago</div>
                                </div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon"
                                    style="background-color: var(--secondary-light); color: var(--secondary);">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="activity-details">
                                    <h4>Sunday Service</h4>
                                    <p>Attendance recorded: 876 members</p>
                                    <div class="activity-time">1 day ago</div>
                                </div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon"
                                    style="background-color: var(--accent-light); color: var(--accent);">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="activity-details">
                                    <h4>Notification Sent</h4>
                                    <p>Weekly bulletin sent to all members</p>
                                    <div class="activity-time">2 days ago</div>
                                </div>
                            </li>
                        </ul>

                        <div class="quick-actions">
                            <h3 class="section-title">Quick Actions</h3>
                            <div class="action-buttons">
                                <a href="{{ route('admin.officers') }}" class="action-button action-primary">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Assign Roles</span>
                                </a>

                                <a href="{{ route('admin.events.create') }}" class="action-button action-secondary">
                                    <i class="fas fa-calendar-plus"></i>
                                    <span>Create Event</span>
                                </a>

                                <a href="{{ route('admin.notifications.create') }}" class="action-button action-primary">
                                    <i class="fas fa-envelope"></i>
                                    <span>Send Notification</span>
                                </a>

                                <a href="{{ route('admin.reports') }}" class="action-button action-accent">
                                    <i class="fas fa-file-export"></i>
                                    <span>Generate Report</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="right-column">
                    <!-- Attendance Trend -->
                    <div class="section">
                        <div class="section-header">
                            <div class="section-title">Attendance Trend</div>
                        </div>
                        <div class="chart-container">
                            <canvas id="attendanceTrend" data-labels="{{ $chartLabels }}"
                                data-data="{{ $chartValues }}"></canvas>
                        </div>
                    </div>

                    <!-- Upcoming Events -->
                    <div class="section">
                        <div class="section-header">
                            <div class="section-title">Upcoming Events</div>
                        </div>
                        <ul>
                            @forelse ($upcomingEvents as $events)
                                <li class="event-item">
                                    <div class="event-icon">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                    <div class="event-details">
                                        <h4> {{  $events->event->event_name }}</h4>
                                        <p>{{  $events->occurrence_date->format('M d, Y') }}</p>
                                    </div>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>

                    <!-- Birthdays This Week -->
                    <div class="section">
                        <div class="section-header">
                            <div class="section-title">Birthdays This Week</div>
                        </div>
                        <ul>
                            @forelse ($birthdaysThisWeek as $birthday)
                                <li class="birthday-item">
                                    <div class="birthday-icon">
                                        <i class="fas fa-birthday-cake"></i>
                                    </div>
                                    <div class="birthday-details">
                                        <h4>{{ $birthday->first_name }} {{ $birthday->last_name }}</h4>
                                        <p>{{  $member->birthdate->format('M d, Y') }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="birthday-item">
                                    <div class="birthday-icon">
                                        <i class="fas fa-birthday-cake"></i>
                                    </div>
                                    <div class="birthday-details">
                                        <h4>There are no birthdays this week.</h4>
                                        <p>{{  now()->format('M d, Y') }}</p>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('attendanceTrend');

                if (ctx) {
                    const labels = JSON.parse(ctx.dataset.labels);
                    const values = JSON.parse(ctx.dataset.data);

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{
                                label: 'Present (monthly) ',
                                data: values,
                                borderColor: '#4361ee',
                                backgroundColor: 'rgba(67, 97, 238, 0.15)',
                                tension: 0.35,
                                borderWidth: 3,
                                pointRadius: 4,
                                pointBackgroundColor: '#4361ee',
                                fill: true,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    grid: {
                                        color: '#e2e8f0'
                                    },
                                    beginAtZero: false,
                                }
                            }
                        }
                    });
                }
            });
        </script>
    </body>

    </html>
@endsection