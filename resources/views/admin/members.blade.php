@extends('layout.admin')
@section('styles')
    <link href="{{ asset('css/admin/members.css') }}" rel="stylesheet">
@endsection

@section('header')
<!-- Members Header -->
<div class="members-header">
    <div class="members-title">
        <h1>Member Management</h1>
        <p>View and manage all church members</p>
    </div>

    <div class="members-controls">
        <div class="members-search">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search members...">
        </div>

        <div class="members-actions">
            <button class="btn btn-outline">
                <i class="fas fa-filter"></i> Filters
            </button>
            <button class="btn btn-primary" id="addMemberBtn">
                <i class="fas fa-user-plus"></i> Add Member
            </button>
        </div>
    </div>
</div>
@endSection

@section('content')
    <!-- Filters -->
    <div class="members-filters">
        <div class="filter-group">
            <label>Status:</label>
            <select>
                <option>All Members</option>
                <option>Active</option>
                <option>Inactive</option>
                <option>Visitors</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Group:</label>
            <select>
                <option>All Groups</option>
                <option>Sunday School</option>
                <option>Youth Group</option>
                <option>Choir</option>
                <option>Volunteers</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Sort By:</label>
            <select>
                <option>Recently Added</option>
                <option>Name (A-Z)</option>
                <option>Name (Z-A)</option>
                <option>Join Date</option>
            </select>
        </div>
    </div>

    <!-- Members Stats -->
    <div class="members-stats">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Total Members</div>
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">1,248</div>
            <div class="stat-footer">+12 this month</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Active Members</div>
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-value">1,042</div>
            <div class="stat-footer">83.5% active</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">First Timers</div>
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-value">38</div>
            <div class="stat-footer">This month</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Volunteers</div>
                <i class="fas fa-hands-helping"></i>
            </div>
            <div class="stat-value">156</div>
            <div class="stat-footer">12.5% of members</div>
        </div>
    </div>

    <!-- Members Table -->
    <div class="members-table-container">
        <table class="members-table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Contact</th>
                    <th>Join Date</th>
                    <th>Status</th>
                    <th>Groups</th>
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
                    <td>(555) 123-4567</td>
                    <td>Jun 12, 2022</td>
                    <td><span class="status-badge status-active">Active</span></td>
                    <td>Sunday School, Choir</td>
                    <td>
                        <button class="action-btn edit-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="action-btn delete-btn">
                            <i class="fas fa-trash"></i>
                        </button>
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
                    <td>(555) 987-6543</td>
                    <td>Mar 5, 2023</td>
                    <td><span class="status-badge status-visitor">Visitor</span></td>
                    <td>-</td>
                    <td>
                        <button class="action-btn edit-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="action-btn delete-btn">
                            <i class="fas fa-trash"></i>
                        </button>
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
                    <td>(555) 456-7890</td>
                    <td>Jan 15, 2021</td>
                    <td><span class="status-badge status-inactive">Inactive</span></td>
                    <td>Youth Group</td>
                    <td>
                        <button class="action-btn edit-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="action-btn delete-btn">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <div class="pagination-info">
                Showing 1-10 of 1,248 members
            </div>
            <div class="pagination-controls">
                <button class="page-btn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">...</button>
                <button class="page-btn">125</button>
                <button class="page-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
@endsection