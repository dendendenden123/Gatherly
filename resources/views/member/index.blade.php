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
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar bg-white w-64 md:w-20 lg:w-64 flex-shrink-0 shadow-md">
            <div
                class="p-4 border-b border-gray-200 flex items-center justify-between md:justify-center lg:justify-between">
                <span class="text-xl font-bold text-primary md:hidden lg:block">GraceConnect</span>
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
                        <h4 class="font-medium">John Smith</h4>
                        <p class="text-xs text-gray-500">Member since 2018</p>
                    </div>
                </div>

                <nav class="space-y-2">
                    <a href="#"
                        class="flex items-center space-x-3 p-2 rounded-lg bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-house-door"></i>
                        <span class="md:hidden lg:block">Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <i class="bi bi-calendar-check"></i>
                        <span class="md:hidden lg:block">Attendance</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <i class="bi bi-people"></i>
                        <span class="md:hidden lg:block">Family</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <i class="bi bi-megaphone"></i>
                        <span class="md:hidden lg:block">Announcements</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <i class="bi bi-collection-play"></i>
                        <span class="md:hidden lg:block">Sermons</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="md:hidden lg:block">Messages</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <i class="bi bi-list-task"></i>
                        <span class="md:hidden lg:block">Tasks</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <i class="bi bi-gear"></i>
                        <span class="md:hidden lg:block">Settings</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-900">Member Dashboard</h1>
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

            <!-- Dashboard Content -->
            <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-primary to-secondary rounded-lg p-6 mb-6 text-white">
                    <h2 class="text-2xl font-bold mb-2">Welcome back, John!</h2>
                    <p class="opacity-90">You have 3 upcoming events and 2 unread messages</p>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Monthly Attendance</p>
                                <h3 class="text-2xl font-bold">85%</h3>
                            </div>
                            <div class="relative w-12 h-12">
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="3">
                                    </circle>
                                    <circle cx="18" cy="18" r="16" fill="none" stroke="#2ecc71" stroke-width="3"
                                        stroke-dasharray="100" stroke-dashoffset="15" class="progress-ring__circle">
                                    </circle>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <i class="bi bi-calendar-check text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Upcoming Events</p>
                                <h3 class="text-2xl font-bold">3</h3>
                            </div>
                            <div
                                class="w-12 h-12 rounded-full bg-primary bg-opacity-10 flex items-center justify-center">
                                <i class="bi bi-calendar-event text-primary text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Unread Messages</p>
                                <h3 class="text-2xl font-bold">2</h3>
                            </div>
                            <div
                                class="w-12 h-12 rounded-full bg-primary bg-opacity-10 flex items-center justify-center">
                                <i class="bi bi-chat-left-text text-primary text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Pending Tasks</p>
                                <h3 class="text-2xl font-bold">1</h3>
                            </div>
                            <div
                                class="w-12 h-12 rounded-full bg-primary bg-opacity-10 flex items-center justify-center">
                                <i class="bi bi-list-check text-primary text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Attendance Tracking -->
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="p-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold">Family Attendance</h2>
                            </div>
                            <div class="p-4">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Name</th>
                                                <th scope="col"
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Last Attended</th>
                                                <th scope="col"
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Monthly %</th>
                                                <th scope="col"
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                            <i class="bi bi-person text-gray-500"></i>
                                                        </div>
                                                        <div class="ml-3">
                                                            <p class="text-sm font-medium">John Smith</p>
                                                            <p class="text-xs text-gray-500">Head</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Sun, Jun
                                                    11</td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="bg-primary h-2 rounded-full" style="width: 85%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                            <i class="bi bi-person text-gray-500"></i>
                                                        </div>
                                                        <div class="ml-3">
                                                            <p class="text-sm font-medium">Sarah Smith</p>
                                                            <p class="text-xs text-gray-500">Spouse</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Sun, Jun
                                                    11</td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="bg-primary h-2 rounded-full" style="width: 75%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                            <i class="bi bi-person text-gray-500"></i>
                                                        </div>
                                                        <div class="ml-3">
                                                            <p class="text-sm font-medium">Emily Smith</p>
                                                            <p class="text-xs text-gray-500">Child</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Sun, Jun 4
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="bg-primary h-2 rounded-full" style="width: 60%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Irregular</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    <button class="text-primary hover:text-secondary font-medium flex items-center">
                                        <i class="bi bi-plus-circle mr-1"></i> Add Family Member
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Sermons -->
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                                <h2 class="text-lg font-semibold">Recent Sermons</h2>
                                <a href="#" class="text-sm text-primary hover:text-secondary">View All</a>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                        <div class="relative pt-[56.25%] bg-gray-100">
                                            <i
                                                class="bi bi-play-circle absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-4xl text-primary opacity-80"></i>
                                        </div>
                                        <div class="p-3">
                                            <h3 class="font-medium mb-1">The Heart of Worship</h3>
                                            <p class="text-sm text-gray-500 mb-2">Pastor John Smith | June 11, 2023</p>
                                            <div class="flex justify-between items-center">
                                                <span
                                                    class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">John
                                                    4:23-24</span>
                                                <div class="flex space-x-2">
                                                    <button class="text-gray-400 hover:text-primary">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                    <button class="text-gray-400 hover:text-primary">
                                                        <i class="bi bi-share"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                        <div class="relative pt-[56.25%] bg-gray-100">
                                            <i
                                                class="bi bi-play-circle absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-4xl text-primary opacity-80"></i>
                                        </div>
                                        <div class="p-3">
                                            <h3 class="font-medium mb-1">Faith in Action</h3>
                                            <p class="text-sm text-gray-500 mb-2">Pastor Michael Johnson | June 4, 2023
                                            </p>
                                            <div class="flex justify-between items-center">
                                                <span
                                                    class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">James
                                                    2:14-26</span>
                                                <div class="flex space-x-2">
                                                    <button class="text-gray-400 hover:text-primary">
                                                        <i class="bi bi-download"></i>
                                                    </button>
                                                    <button class="text-gray-400 hover:text-primary">
                                                        <i class="bi bi-share"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Upcoming Events -->
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                                <h2 class="text-lg font-semibold">Upcoming Events</h2>
                                <a href="#" class="text-sm text-primary hover:text-secondary">View All</a>
                            </div>
                            <div class="p-4">
                                <div class="space-y-4">
                                    <div class="flex items-start">
                                        <div class="bg-primary text-white p-2 rounded text-center mr-3 flex-shrink-0">
                                            <div class="text-sm font-bold">15</div>
                                            <div class="text-xs">JUN</div>
                                        </div>
                                        <div>
                                            <h3 class="font-medium">Vacation Bible School</h3>
                                            <p class="text-sm text-gray-500">9:00 AM - 12:00 PM</p>
                                            <div class="mt-1">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="bi bi-check-circle mr-1"></i> Registered
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="bg-primary text-white p-2 rounded text-center mr-3 flex-shrink-0">
                                            <div class="text-sm font-bold">18</div>
                                            <div class="text-xs">JUN</div>
                                        </div>
                                        <div>
                                            <h3 class="font-medium">Men's Breakfast</h3>
                                            <p class="text-sm text-gray-500">8:00 AM - 10:00 AM</p>
                                            <div class="mt-1">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="bi bi-exclamation-circle mr-1"></i> Not RSVP'd
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="bg-primary text-white p-2 rounded text-center mr-3 flex-shrink-0">
                                            <div class="text-sm font-bold">25</div>
                                            <div class="text-xs">JUN</div>
                                        </div>
                                        <div>
                                            <h3 class="font-medium">Church Picnic</h3>
                                            <p class="text-sm text-gray-500">4:00 PM - 8:00 PM</p>
                                            <div class="mt-1">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="bi bi-question-circle mr-1"></i> Tentative
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Missed Events -->
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="p-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold">Missed Events</h2>
                            </div>
                            <div class="p-4">
                                <div class="flex items-start mb-3">
                                    <div class="bg-gray-200 text-gray-600 p-2 rounded text-center mr-3 flex-shrink-0">
                                        <div class="text-sm font-bold">11</div>
                                        <div class="text-xs">JUN</div>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Sunday Service</h3>
                                        <p class="text-sm text-gray-500">10:30 AM</p>
                                        <div class="mt-1 text-sm">
                                            <a href="#" class="text-primary hover:text-secondary">Watch recording</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="bg-gray-200 text-gray-600 p-2 rounded text-center mr-3 flex-shrink-0">
                                        <div class="text-sm font-bold">7</div>
                                        <div class="text-xs">JUN</div>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Bible Study</h3>
                                        <p class="text-sm text-gray-500">7:00 PM</p>
                                        <div class="mt-1 text-sm">
                                            <a href="#" class="text-primary hover:text-secondary">View notes</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks -->
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                                <h2 class="text-lg font-semibold">Your Tasks</h2>
                                <a href="#" class="text-sm text-primary hover:text-secondary">View All</a>
                            </div>
                            <div class="p-4">
                                <div class="space-y-3">
                                    <div class="flex items-start">
                                        <input type="checkbox" class="mt-1 mr-3" checked>
                                        <div class="flex-1">
                                            <p class="line-through text-gray-500">Sign up for VBS volunteer</p>
                                            <p class="text-xs text-gray-400">Completed Jun 5</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <input type="checkbox" class="mt-1 mr-3">
                                        <div class="flex-1">
                                            <p>Submit prayer request for missions trip</p>
                                            <p class="text-xs text-gray-400">Due Jun 20</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <input type="checkbox" class="mt-1 mr-3">
                                        <div class="flex-1">
                                            <p>Complete discipleship course lesson 3</p>
                                            <p class="text-xs text-gray-400">Due Jun 25</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button
                                        class="text-primary hover:text-secondary font-medium flex items-center text-sm">
                                        <i class="bi bi-plus-circle mr-1"></i> Add Task
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
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