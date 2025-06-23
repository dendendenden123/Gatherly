<!-- sections/yield: styles, header, header-text, header-subtext, content -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatherly - Church Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2ecc71',
                        secondary: '#27ae60',
                        accent: '#e74c3c',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            --white: #fff;
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

        h2 {
            font-size: unset;
            font-weight: unset;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: var(--light-gray);
            color: var(--text-dark);
        }


        /* Mobile First Approach */

        /* Header for Mobile */
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

        .mobile-user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: var(--medium-gray);
        }

        /* Sidebar - Hidden on Mobile by Default */
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

        .logo {
            padding: 0 20px 20px;
            border-bottom: 1px solid var(--medium-gray);
            margin-bottom: 20px;
        }

        .logo h2 {
            color: var(--primary-green);
        }

        .logo span {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .nav-menu {
            flex-grow: 1;
            overflow-y: auto;
        }

        .nav-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .nav-item:hover {
            background-color: var(--medium-gray);
        }

        .nav-item.active {
            background-color: var(--primary-green);
            color: white;
        }

        .nav-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .user-profile {
            padding: 20px;
            display: flex;
            align-items: center;
            border-top: 1px solid var(--medium-gray);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--medium-gray);
            margin-right: 10px;
            overflow: hidden;
        }

        .user-info h4 {
            font-size: 0.9rem;
        }

        .user-info p {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            padding: 20px;
            margin-top: 65px;
            /* Space for mobile header */
        }

        .header {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .page-title {
            margin-bottom: 15px;
        }

        .page-title h1 {
            font-size: 1.5rem;
            color: var(--text-dark);
        }

        .page-title p {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .search-bar {
            position: relative;
            flex-grow: 1;
            margin-right: 10px;
        }

        .search-bar input {
            padding: 8px 15px 8px 35px;
            border: 1px solid var(--medium-gray);
            border-radius: 20px;
            width: 100%;
        }

        .search-bar i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-gray);
        }

        .notification-bell {
            position: relative;
            cursor: pointer;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--accent-red);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

        /* Dashboard Widgets */
        .dashboard-widgets {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .widget {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .widget-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .widget-title {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .widget-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--primary-green);
        }

        .widget-footer {
            display: flex;
            align-items: center;
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .widget-footer i {
            margin-right: 5px;
        }

        .positive {
            color: var(--primary-green);
        }

        .negative {
            color: var(--accent-red);
        }

        /* Main Sections */
        .main-sections {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .section {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .section-actions a {
            color: var(--primary-green);
            text-decoration: none;
            font-size: 0.8rem;
        }

        /* Members Table */
        .members-table {
            width: 100%;
            border-collapse: collapse;
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        .members-table th {
            text-align: left;
            padding: 8px 0;
            border-bottom: 1px solid var(--medium-gray);
            color: var(--text-light);
            font-weight: 500;
        }

        .members-table td {
            padding: 10px 0;
            border-bottom: 1px solid var(--medium-gray);
        }

        .member-info {
            display: flex;
            align-items: center;
        }

        .member-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--medium-gray);
            margin-right: 8px;
            overflow: hidden;
        }

        .member-name {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .member-email {
            font-size: 0.7rem;
            color: var(--text-light);
        }

        .status-badge {
            padding: 3px 6px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .status-active {
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--primary-green);
        }

        .status-inactive {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--accent-red);
        }

        .action-btn {
            padding: 4px 8px;
            border-radius: 4px;
            border: none;
            background-color: transparent;
            cursor: pointer;
            font-size: 0.7rem;
        }

        .edit-btn {
            color: var(--primary-green);
            border: 1px solid var(--primary-green);
            margin-right: 3px;
        }

        .delete-btn {
            color: var(--accent-red);
            border: 1px solid var(--accent-red);
        }

        /* Recent Activity */
        .activity-list {
            list-style: none;
        }

        .activity-item {
            display: flex;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .activity-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .activity-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: var(--medium-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            color: var(--primary-green);
            flex-shrink: 0;
        }

        .activity-details h4 {
            font-size: 0.8rem;
            margin-bottom: 3px;
        }

        .activity-details p {
            font-size: 0.7rem;
            color: var(--text-light);
        }

        .activity-time {
            font-size: 0.6rem;
            color: var(--dark-gray);
        }

        /* Quick Actions */
        .quick-actions {
            margin-top: 15px;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .action-button {
            padding: 10px;
            border-radius: 6px;
            border: none;
            background-color: var(--primary-green);
            color: white;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.3s;
            font-size: 0.7rem;
        }

        .action-button:hover {
            background-color: var(--dark-green);
        }

        .action-button i {
            font-size: 1rem;
            margin-bottom: 3px;
        }

        .action-button span {
            font-size: 0.7rem;
        }

        .action-button.red {
            background-color: var(--accent-red);
        }

        .action-button.red:hover {
            background-color: #c0392b;
        }

        /* Overlay for mobile menu */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 98;
            display: none;
        }

        .overlay.active {
            display: block;
        }

        /* Tablet Styles */
        @media (min-width: 768px) {
            body {
                flex-direction: row;
            }

            .mobile-header {
                display: none;
            }

            .sidebar {
                display: flex;
                position: fixed;
                transform: translateX(0);
                height: 100vh;
            }

            .main-content {
                margin-top: 0;
                margin-left: 250px;
                /* Space for sidebar */
            }

            .dashboard-widgets {
                grid-template-columns: repeat(2, 1fr);
            }

            .header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 25px;
            }

            .page-title {
                margin-bottom: 0;
            }

            .header-actions {
                justify-content: flex-end;
            }

            .search-bar {
                width: 200px;
            }

            .main-sections {
                grid-template-columns: 1fr;
            }
        }

        /* Desktop Styles */
        @media (min-width: 1024px) {
            .dashboard-widgets {
                grid-template-columns: repeat(3, 1fr);
            }

            .main-sections {
                grid-template-columns: 2fr 1fr;
            }

            .widget {
                padding: 20px;
            }

            .section {
                padding: 20px;
            }

            .widget-value {
                font-size: 1.8rem;
            }

            .widget-title {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.2rem;
            }

            .member-name {
                font-size: 1rem;
            }

            .activity-details h4 {
                font-size: 0.9rem;
            }

            .action-button {
                padding: 12px;
                font-size: 0.8rem;
            }

            .action-button i {
                font-size: 1.2rem;
            }
        }
    </style>
    @yield('styles')
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

    <!-- Overlay for Mobile Menu -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h2>Gatherly</h2>
            <span>Church Management System</span>
        </div>

        <div class="nav-menu">
            <div class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-reset">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item {{ request()->is('admin/members') ? 'active' : '' }}">
                <a href="{{ route('admin.members') }}" class="text-decoration-none text-reset">
                    <i class="fas fa-users"></i>
                    <span>Members</span>
                </a>
            </div>
            <div class="nav-item {{ request()->is('admin/attendance') ? 'active' : '' }}">
                <a href="{{ route('admin.attendance') }}" class="text-decoration-none text-reset">
                    <i class="fas fa-calendar-check"></i>
                    <span>Attendance</span>
                </a>
            </div>
            <div class="nav-item {{ request()->is('admin/reports') ? 'active' : '' }}">
                <a href="{{ route('admin.reports') }}" class="text-decoration-none text-reset">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </div>
            <div
                class="nav-item {{ request()->is('admin/notifications') || request()->is('admin/notifications/*') ? 'active' : '' }}">
                <a href="{{ route('admin.notifications.index') }}" class="text-decoration-none text-reset">
                    <i class="fas fa-bell"></i>
                    <span>Notifications</span>
                </a>
            </div>

            <div class="nav-item {{ request()->is('admin/officers') ? 'active' : '' }}">
                <a href="{{ route('admin.officers') }}" class="text-decoration-none text-reset">
                    <i class="fas fa-user-tie"></i>
                    <span>Officers</span>
                </a>
            </div>
            <div class="nav-item {{ request()->is('admin/events') ? 'active' : '' }}">
                <a href="{{ route('admin.events.index') }}" class="text-decoration-none text-reset">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Events</span>
                </a>
            </div>
            <div class="nav-item  {{ request()->is('admin/engagements') ? 'active' : '' }}">
                <a href="{{ route('admin.engagements.index') }}" class="text-decoration-none text-reset">
                    <i class="fas fa-chart-line"></i>
                    <span>Engagements</span>
                </a>
            </div>
            <div class="nav-item {{ request()->is('admin/settings') ? 'active' : '' }}">
                <a href="#" class="text-decoration-none text-reset">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </div>
            <div class="nav-item {{ request()->is('logout') ? 'active' : '' }}">
                <a href="/logout" class="text-decoration-none text-reset">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

        <div class="user-profile">
            <div class="user-avatar">
                <img src="" alt="User">
            </div>
            <div class="user-info">
                <h4>Admin User</h4>
                <p>System Administrator</p>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        @section('header')
        <div class="header">
            <div class="page-title">
                <h1>@yield('header-text', 'Dashboard Overview')</h1>
                <p>@yield('header-subtext', "Welcome back! Here's what's happening with your church today.")</p>
            </div>

            <div class="header-actions">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <div class="notification-bell">
                    <i class="fas fa-bell"></i>
                    <div class="notification-badge">3</div>
                </div>
            </div>
        </div>
        @show

        <!-- Main Sections -->
        @yield('content')
    </div>

    <script>
        // Mobile menu toggle functionality
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        // Close menu when clicking on a nav item (for mobile)
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            });
        });

        // Responsive adjustments
        function handleResize() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        }

        window.addEventListener('resize', handleResize);
    </script>
</body>

</html>