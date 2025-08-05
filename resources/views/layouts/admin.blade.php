<!-- sections/yield: styles, header, header-text, header-subtext, content -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gatherly - Church Management System</title>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2ecc71',
                        secondary: '#27ae60',
                        accent: '#e74c3c',
                        'primary-green': '#2ecc71',
                        'dark-green': '#27ae60',
                        'accent-red': '#e74c3c',
                        'light-gray': '#f5f5f5',
                    }
                }
            }

            module.exports = {
                content: [
                    "./node_modules/flowbite/**/*.js",
                    "./**/*.html",
                ],
                plugins: [
                    require('flowbite/plugin')
                ]
            }
        }
    </script>


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js'></script>
    <link rel="stylesheet" href="{{ asset('css/layouts/admin.css') }}">
    <!-- CSS for full calender -->

    <!-- JS Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JS for full calender -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    @livewireStyles
    @livewireScripts
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
            <div
                class="nav-item {{ request()->is('admin/attendance') || request()->is('admin/attendance/*') ? 'active' : '' }}">
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
            <div
                class="nav-item {{ request()->is('admin/events') || request()->is('admin/events/*') ? 'active' : '' }}">
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