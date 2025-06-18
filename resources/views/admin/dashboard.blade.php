@extends('layouts.admin')
@section('content')
    <!-- Dashboard Widgets -->
    <div class="dashboard-widgets">
        <div class="widget">
            <div class="widget-header">
                <div class="widget-title">Total Members</div>
                <i class="fas fa-users"></i>
            </div>
            <div class="widget-value">1,248</div>
            <div class="widget-footer">
                <i class="fas fa-arrow-up positive"></i>
                <span class="positive">12% from last month</span>
            </div>
        </div>

        <div class="widget">
            <div class="widget-header">
                <div class="widget-title">Weekly Attendance</div>
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="widget-value">876</div>
            <div class="widget-footer">
                <i class="fas fa-arrow-up positive"></i>
                <span class="positive">5% from last week</span>
            </div>
        </div>

        <div class="widget">
            <div class="widget-header">
                <div class="widget-title">Upcoming Events</div>
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="widget-value">7</div>
            <div class="widget-footer">
                <span>This week</span>
            </div>
        </div>
    </div>
    <!-- Main Sections -->
    <div class="main-sections">
        <div class="section">
            <div class="section-header">
                <div class="section-title">Recent Members</div>
                <div class="section-actions">
                    <a href="#">View All</a>
                </div>
            </div>

            <table class="members-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Join Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="member-info">
                                <div class="member-avatar"></div>
                                <div>
                                    <div class="member-name">Sarah Johnson</div>
                                    <div class="member-email">sarah@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td>Jun 12, 2023</td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td>
                            <button class="action-btn edit-btn">Edit</button>
                            <button class="action-btn delete-btn">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="member-info">
                                <div class="member-avatar"></div>
                                <div>
                                    <div class="member-name">Michael Brown</div>
                                    <div class="member-email">michael@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td>Jun 10, 2023</td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td>
                            <button class="action-btn edit-btn">Edit</button>
                            <button class="action-btn delete-btn">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="member-info">
                                <div class="member-avatar"></div>
                                <div>
                                    <div class="member-name">Emily Davis</div>
                                    <div class="member-email">emily@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td>Jun 5, 2023</td>
                        <td><span class="status-badge status-inactive">Inactive</span></td>
                        <td>
                            <button class="action-btn edit-btn">Edit</button>
                            <button class="action-btn delete-btn">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="member-info">
                                <div class="member-avatar"></div>
                                <div>
                                    <div class="member-name">Robert Wilson</div>
                                    <div class="member-email">robert@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td>May 28, 2023</td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td>
                            <button class="action-btn edit-btn">Edit</button>
                            <button class="action-btn delete-btn">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="member-info">
                                <div class="member-avatar"></div>
                                <div>
                                    <div class="member-name">Jennifer Lee</div>
                                    <div class="member-email">jennifer@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td>May 20, 2023</td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td>
                            <button class="action-btn edit-btn">Edit</button>
                            <button class="action-btn delete-btn">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-title">Recent Activity</div>
                <div class="section-actions">
                    <a href="#">View All</a>
                </div>
            </div>

            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="activity-details">
                        <h4>New Member Added</h4>
                        <p>Sarah Johnson joined the church</p>
                        <div class="activity-time">2 hours ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="activity-details">
                        <h4>Sunday Service</h4>
                        <p>Attendance recorded: 876 members</p>
                        <div class="activity-time">1 day ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="activity-details">
                        <h4>Notification Sent</h4>
                        <p>Weekly bulletin sent to all members</p>
                        <div class="activity-time">2 days ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="activity-details">
                        <h4>Officer Assignment</h4>
                        <p>Michael Brown assigned as Small Group Leader</p>
                        <div class="activity-time">3 days ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <div class="activity-details">
                        <h4>Volunteer Signup</h4>
                        <p>5 new volunteers for Food Bank event</p>
                        <div class="activity-time">4 days ago</div>
                    </div>
                </li>
            </ul>

            <div class="quick-actions">
                <h3 class="section-title">Quick Actions</h3>
                <div class="action-buttons">
                    <button class="action-button">
                        <i class="fas fa-user-plus"></i>
                        <span>Add Member</span>
                    </button>
                    <button class="action-button">
                        <i class="fas fa-calendar-plus"></i>
                        <span>Create Event</span>
                    </button>
                    <button class="action-button">
                        <i class="fas fa-envelope"></i>
                        <span>Send Message</span>
                    </button>
                    <button class="action-button red">
                        <i class="fas fa-file-export"></i>
                        <span>Generate Report</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection