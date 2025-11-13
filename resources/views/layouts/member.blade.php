<!-- sections/yield: styles, header, header-text, content -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Grace Community | Member Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
    <style>
        .sidebar {
            transition: all 0.3s ease;
            transform: translateX(0);
            position: fixed;
            height: 100vh;
            z-index: 40;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar-open {
                transform: translateX(0);
            }
        }

        .main-content {
            transition: margin 0.3s ease;
            margin-left: 16rem;
            /* 64 * 4 = 256px */
        }

        @media (max-width: 1024px) {
            .main-content {
                margin-left: 5rem;
                /* 20 * 4 = 80px */
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }

        .sidebar-collapsed .main-content {
            margin-left: 5rem;
        }

        .notification-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            background-color: #e74c3c;
            border-radius: 50%;
        }

        .progress-ring__circle {
            transition: stroke-dashoffset 0.35s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .family-member-card {
            transition: all 0.3s ease;
        }

        .family-member-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .progress-ring__circle {
            transition: stroke-dashoffset 0.35s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .sermon-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .video-thumbnail:hover .play-icon {
            transform: scale(1.1);
        }

        .series-tag {
            transition: all 0.3s ease;
        }

        .series-tag:hover {
            background-color: #27ae60;
            color: white;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get DOM elements
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeSidebar = document.getElementById('close-sidebar');
            const toggleSidebar = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            // Check if elements exist before adding event listeners
            if (mobileMenuButton && sidebar) {
                // Toggle mobile menu
                mobileMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('sidebar-open');
                });
            }

            if (closeSidebar && sidebar) {
                // Close mobile menu
                closeSidebar.addEventListener('click', () => {
                    sidebar.classList.remove('sidebar-open');
                });
            }

            if (toggleSidebar) {
                // Toggle desktop sidebar
                toggleSidebar.addEventListener('click', () => {
                    document.body.classList.toggle('sidebar-collapsed');
                    const icon = toggleSidebar.querySelector('i');
                    if (document.body.classList.contains('sidebar-collapsed')) {
                        icon.classList.remove('bi-chevron-left');
                        icon.classList.add('bi-chevron-right');
                    } else {
                        icon.classList.remove('bi-chevron-right');
                        icon.classList.add('bi-chevron-left');
                    }
                });
            }

            // Close mobile menu when clicking outside
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 768 && sidebar && mobileMenuButton) {
                    if (!sidebar.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                        sidebar.classList.remove('sidebar-open');
                    }
                }
            });

            // Handle window resize
            function handleResize() {
                if (!sidebar) return;

                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('sidebar-open');
                    sidebar.style.transform = 'translateX(0)';
                } else {
                    if (!sidebar.classList.contains('sidebar-open')) {
                        sidebar.style.transform = 'translateX(-100%)';
                    }
                }
            }

            // Initial call
            handleResize();

            // Add event listener
            window.addEventListener('resize', handleResize);

            // Clean up event listener when component unmounts
            return () => {
                window.removeEventListener('resize', handleResize);
            };
        });
    </script>
    @yield('styles')
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile menu button -->
        <button id="mobile-menu-button" class="md:hidden fixed top-4 left-4 z-50 p-2 rounded-md bg-white shadow-md">
            <i class="bi bi-list text-xl"></i>
        </button>

        <!-- Sidebar -->
        <div id="sidebar" class="sidebar bg-white w-64 md:w-20 lg:w-64 flex-shrink-0 shadow-md">
            <div class="p-4 flex items-center justify-between">
                <span class="text-xl font-bold text-primary hidden md:block">Gatherly</span>
                <i class="bi bi-church text-primary text-2xl md:hidden"></i>
                <button id="close-sidebar" class="text-gray-500 md:hidden">
                    <i class="bi bi-x-lg"></i>
                </button>
                <button id="toggle-sidebar" class="text-gray-500 hidden md:block">
                    <i class="bi bi-chevron-left"></i>
                </button>
            </div>
            <div class="p-4">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="relative">
                        <img   src="{{ Auth::user()->profile_image && !str_contains(Auth::user()->profile_image, 'Default_pfp.jpg') ? asset('storage/' . Auth::user()->profile_image) : Auth::user()->profile_image }}"
                            alt="User" class="w-10 h-10 rounded-full object-cover">
                        <span
                            class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                    <div class="md:hidden lg:block">
                        <h4 class="font-medium">{{ Auth::user()->first_name . " " . Auth::user()->last_name}}</h4>
                        <p class="text-xs text-gray-500">Member since {{ Auth::user()->created_at->year }}</p>
                    </div>
                </div>

                <nav class="space-y-2">
                    <a href="/member"
                        class="{{ Request::is('member') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-house-door"></i>
                        <span class="md:hidden lg:block">Dashboard</span>
                    </a>
                    <a href="{{ route('member.profile') }}"
                        class="{{ Request::is('member/profile') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-person"></i>
                        <span class="md:hidden lg:block">Profile</span>
                    </a>
                    <a href="{{ route('my.attendance') }}"
                        class="{{ Request::is('member/attendance') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-calendar-check"></i>
                        <span class="md:hidden lg:block">My Attendance</span>
                    </a>
                    <a href="{{ route('member.notification') }}"
                        class="{{ Request::is('member/notification') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-calendar-event"></i>
                        <span class="md:hidden lg:block">Notifications</span>
                    </a>

                    <a href="{{ route('member.event') }}"
                        class="{{ Request::is('member/event') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-calendar-event"></i>
                        <span class="md:hidden lg:block">Events</span>
                    </a>
                    <a href="/member/sermon"
                        class="{{ Request::is('member/sermon') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-collection-play"></i>
                        <span class="md:hidden lg:block">Sermons</span>
                    </a>
                    <a href="{{ route('member.task') }}"
                        class="{{ Request::is('member/task') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-list-task"></i>
                        <span class="md:hidden lg:block">Tasks</span>
                    </a>
                    @secretary
                    <a href="{{ route('admin.attendance') }}"
                        class="{{ Request::is('admin/attendance') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-calendar-check"></i>
                        <span class="md:hidden lg:block">Manage Attendance</span>
                    </a>
                    @endsecretary
                    <a href="/logout"
                        class="flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="md:hidden lg:block">logout</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div id="main-content" class="flex-1 overflow-auto main-content">
            <!-- Header -->
            @section('header')
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-900">@yield('header-text', 'Member Dashboard')</h1>

                </div>
            </header>
            @show
            <!-- Main Content Grid -->
            @yield('content')
        </div>

        <script>
            // Mobile menu toggle
            const mobileMenuButton = document.querySelector('.md\\:hidden.text-gray-500');
            const sidebar = document.querySelector('.sidebar');

            mobileMenuButton.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
            });

            // Simulate loading progress
            setTimeout(() => {
                const progressCircle = document.querySelector('.progress-ring__circle');
                if (progressCircle) {
                    progressCircle.style.strokeDashoffset = '25';
                }
            }, 500);
        </script>
</body>

</html>