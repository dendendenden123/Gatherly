@extends('layouts.member')
@section('content')

    <!-- Dashboard Content -->
    <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-primary to-secondary rounded-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold mb-2">Welcome back, John!</h2>
            <p class="opacity-90">You have 3 upcoming events and 2 unread notifications</p>
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
                    <div class="w-12 h-12 rounded-full bg-primary bg-opacity-10 flex items-center justify-center">
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
                    <div class="w-12 h-12 rounded-full bg-primary bg-opacity-10 flex items-center justify-center">
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
                    <div class="w-12 h-12 rounded-full bg-primary bg-opacity-10 flex items-center justify-center">
                        <i class="bi bi-list-check text-primary text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
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
                                                    <p class="text-sm font-medium">
                                                        {{ Auth::user()->first_name . " " . Auth::user()->last_name}}
                                                    </p>
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
                                    <p class="text-sm text-gray-500 mb-2">
                                        {{ Auth::user()->first_name . " " . Auth::user()->last_name}} | June 11, 2023
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">John
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
                                        <span class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">James
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
                        <a href="{{ route('member.event') }}" class="text-sm text-primary hover:text-secondary">View All</a>
                    </div>
                    <div class="p-4">
                        <div class="space-y-4">
                            @forelse ($upcomingEvents as $event)
                                <div class="flex items-start">
                                    <div class="bg-primary text-white p-2 rounded text-center mr-3 flex-shrink-0">
                                        <div class="text-sm font-bold">{{ $event->occurrence_date->format('M') }}</div>
                                        <div class="text-xs">{{ $event->occurrence_date->format('d') }}</div>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">{{ $event->event->event_name }}</h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $event->occurrence_date->format('h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="flex items-start">
                                    <div class="bg-primary text-white p-2 rounded text-center mr-3 flex-shrink-0">
                                        <div class="text-sm font-bold">15</div>
                                        <div class="text-xs">JUN</div>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">No more events</h3>
                                        <p class="text-sm text-gray-500">9:00 AM - 12:00 PM</p>
                                        <div class="mt-1">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                <i class="bi bi-check-circle mr-1"></i> Registered
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Missed Events -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold">Missed Events</h2>
                    </div>
                    <div class="p-4">
                        @forelse($missedEvents as $event)
                            <div class="flex items-start mb-3">
                                <div class="bg-gray-200 text-gray-600 p-2 rounded text-center mr-3 flex-shrink-0">
                                    <div class="text-sm font-bold">{{ $event->occurrence_date->format('d') }}</div>
                                    <div class="text-xs">{{ $event->occurrence_date->format('M') }}</div>
                                </div>
                                <div>
                                    <h3 class="font-medium">{{ $event->event->event_name }}</h3>

                                    <div class="mt-1 text-sm">
                                        <a href="#"
                                            class="text-primary hover:text-secondary">{{ $event->event->event_description }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="flex items-start mb-3">
                                <div>
                                    <h3 class="font-medium">You have no missed events</h3>
                                </div>
                            </div>
                        @endforelse

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
                            <button class="text-primary hover:text-secondary font-medium flex items-center text-sm">
                                <i class="bi bi-plus-circle mr-1"></i> Add Task
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>
@endsection