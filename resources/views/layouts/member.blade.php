<!-- sections/yield: styles, header, header-text, content -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grace Community | Member Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
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
    <style>
        .sidebar {
            transition: all 0.3s ease;
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
    @yield('styles')
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar bg-white w-64 md:w-20 lg:w-64 flex-shrink-0 shadow-md">
            <div class="p-4 flex items-center justify-between md:justify-center lg:justify-between">
                <span class="text-xl font-bold text-primary md:hidden lg:block">Gatherly</span>
                <i class="bi bi-church text-primary text-2xl hidden md:block lg:hidden"></i>
                <button class="text-gray-500 md:hidden">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="p-4">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
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
                    <a href="/member/my-attendance"
                        class="{{ Request::is('member/attendance') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-calendar-check"></i>
                        <span class="md:hidden lg:block">MY Attendance</span>
                    </a>

                    <a href="/member/announcement"
                        class="{{ Request::is('member/announcement') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-megaphone"></i>
                        <span class="md:hidden lg:block">Announcements</span>
                    </a>
                    <a href="/member/sermon"
                        class="{{ Request::is('member/sermon') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-collection-play"></i>
                        <span class="md:hidden lg:block">Sermons</span>
                    </a>
                    <a href="/member/tasks"
                        class="{{ Request::is('member/tasks') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
                        <i class="bi bi-list-task"></i>
                        <span class="md:hidden lg:block">Tasks</span>
                    </a>
                    @secretary
                    <a href="{{ route('member.attendance.index') }}"
                        class="{{ Request::is('member/attendance') ? 'flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary' : 'flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100' }}">
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
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            @section('header')
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-900">@yield('header-text', 'Member Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="text-gray-500 hover:text-gray-700">
                                <i class="bi bi-bell text-xl"></i>
                                <span class="notification-dot"></span>
                            </button>
                        </div>
                        <button class="md:hidden text-gray-500">
                            <i class="bi bi-list text-xl"></i>
                        </button>
                    </div>
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