@extends('layout.member')
@section('content')
    @section('header')
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-900">Attendance History</h1>
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
    @endsection

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Monthly Attendance -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Monthly Attendance</p>
                        <h3 class="text-2xl font-bold">85%</h3>
                        <p class="text-xs text-gray-500">+8% from last month</p>
                    </div>
                    <div class="relative w-16 h-16">
                        <svg class="w-full h-full" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="3"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#2ecc71" stroke-width="3"
                                stroke-dasharray="100" stroke-dashoffset="15" class="progress-ring__circle">
                            </circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="bi bi-calendar-check text-primary text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Streak -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Current Streak</p>
                        <h3 class="text-2xl font-bold">4 weeks</h3>
                        <p class="text-xs text-gray-500">Since May 21</p>
                    </div>
                    <div class="w-16 h-16 rounded-full bg-primary bg-opacity-10 flex items-center justify-center">
                        <i class="bi bi-lightning-charge text-primary text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Favorite Service -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Most Attended</p>
                        <h3 class="text-2xl font-bold">Sunday AM</h3>
                        <p class="text-xs text-gray-500">92% attendance</p>
                    </div>
                    <div class="w-16 h-16 rounded-full bg-primary bg-opacity-10 flex items-center justify-center">
                        <i class="bi bi-heart text-primary text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="time-period" class="block text-sm font-medium text-gray-700 mb-1">Time
                        Period</label>
                    <select id="time-period"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                        <option>Last 30 Days</option>
                        <option>Last 3 Months</option>
                        <option>Last 6 Months</option>
                        <option>This Year</option>
                        <option>All Time</option>
                    </select>
                </div>
                <div>
                    <label for="service-type" class="block text-sm font-medium text-gray-700 mb-1">Service
                        Type</label>
                    <select id="service-type"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                        <option>All Services</option>
                        <option>Sunday Morning</option>
                        <option>Wednesday Night</option>
                        <option>Special Events</option>
                    </select>
                </div>
                <div>
                    <label for="attendance-status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="attendance-status"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                        <option>All Attendance</option>
                        <option>Present Only</option>
                        <option>Absent Only</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md w-full">
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Detailed Attendance List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold">Attendance History</h2>
                <div class="text-sm text-gray-500">Showing last 10 records</div>
            </div>
            <div class="divide-y divide-gray-200">
                <!-- Attendance Record 1 -->
                <div class="p-4 hover:bg-gray-50 transition attendance-card">
                    <div class="flex items-start">
                        <div class="bg-green-100 text-green-800 p-2 rounded text-center mr-4 flex-shrink-0">
                            <div class="text-sm font-bold">11</div>
                            <div class="text-xs">JUN</div>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <h3 class="font-medium">Sunday Morning Service</h3>
                                <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full">Present</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">10:30 AM - 12:00 PM</p>
                            <p class="text-sm mt-2">Sermon: "The Heart of Worship" (John 4:23-24)</p>
                            <div class="mt-2 flex space-x-3 text-sm">
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-play-circle mr-1"></i> Watch
                                </a>
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-journal-text mr-1"></i> Notes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Record 2 -->
                <div class="p-4 hover:bg-gray-50 transition attendance-card">
                    <div class="flex items-start">
                        <div class="bg-green-100 text-green-800 p-2 rounded text-center mr-4 flex-shrink-0">
                            <div class="text-sm font-bold">7</div>
                            <div class="text-xs">JUN</div>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <h3 class="font-medium">Wednesday Bible Study</h3>
                                <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full">Present</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">7:00 PM - 8:30 PM</p>
                            <p class="text-sm mt-2">Topic: "Faith in Action" (James 2:14-26)</p>
                            <div class="mt-2 flex space-x-3 text-sm">
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-play-circle mr-1"></i> Watch
                                </a>
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-journal-text mr-1"></i> Notes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Record 3 -->
                <div class="p-4 hover:bg-gray-50 transition attendance-card">
                    <div class="flex items-start">
                        <div class="bg-green-100 text-green-800 p-2 rounded text-center mr-4 flex-shrink-0">
                            <div class="text-sm font-bold">4</div>
                            <div class="text-xs">JUN</div>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <h3 class="font-medium">Sunday Morning Service</h3>
                                <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full">Present</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">10:30 AM - 12:00 PM</p>
                            <p class="text-sm mt-2">Sermon: "Saved by Grace" (Ephesians 2:8-9)</p>
                            <div class="mt-2 flex space-x-3 text-sm">
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-play-circle mr-1"></i> Watch
                                </a>
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-journal-text mr-1"></i> Notes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Record 4 -->
                <div class="p-4 hover:bg-gray-50 transition attendance-card">
                    <div class="flex items-start">
                        <div class="bg-gray-100 text-gray-800 p-2 rounded text-center mr-4 flex-shrink-0">
                            <div class="text-sm font-bold">28</div>
                            <div class="text-xs">MAY</div>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <h3 class="font-medium">Wednesday Prayer Meeting</h3>
                                <span class="text-sm bg-red-100 text-red-800 px-2 py-1 rounded-full">Absent</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">7:00 PM - 8:00 PM</p>
                            <p class="text-sm mt-2 text-gray-400">You missed this service</p>
                            <div class="mt-2 flex space-x-3 text-sm">
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-play-circle mr-1"></i> Watch
                                </a>
                                <a href="#" class="text-primary hover:text-secondary flex items-center">
                                    <i class="bi bi-journal-text mr-1"></i> Notes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- More records would appear here -->
            </div>
            <div class="p-4 border-t border-gray-200 text-center">
                <button class="text-primary hover:text-secondary font-medium">
                    Load More Attendance Records
                </button>
            </div>
        </div>
    </main>
@endsection