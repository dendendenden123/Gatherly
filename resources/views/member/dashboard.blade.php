@extends('layouts.member')
@section('content')

    <!-- Dashboard Content -->
    <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-primary to-secondary rounded-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->first_name}}!</h2>
            <p class="opacity-90">You have {{ $upcomingEventsCount }} upcoming events and {{ $unreadNotifsCounts }} unread
                notifications</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Engagemenet rate</p>
                        <h3 class="text-2xl font-bold">{{ $userAttendanceRateLastMonth }}%</h3>
                    </div>

                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Upcoming Events</p>
                        <h3 class="text-2xl font-bold">{{ $upcomingEventsCount }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-primary bg-opacity-10 flex items-center justify-center">
                        <i class="bi bi-calendar-event text-primary text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Unread Notifications</p>
                        <h3 class="text-2xl font-bold">{{ $unreadNotifsCounts }}</h3>
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
                        <h3 class="text-2xl font-bold">{{$assignedPendingTaskCount }}</h3>
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
                        <h2 class="text-lg font-semibold">Recent Attendance</h2>
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
                                            Date</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse  ($attendances as $attendance)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <i class="bi bi-person text-gray-500"></i>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm font-medium">
                                                            {{ $attendance->event_occurrence->event->event_name}}
                                                        </p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $attendance->event_occurrence->event->event_type}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                {{ $attendance->event_occurrence->occurrence_date->format('M d, Y')}}
                                            </td>

                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">{{ $attendance->status }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <i class="bi bi-person text-gray-500"></i>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm font-medium">
                                                            You have not attended any events yet
                                                        </p>
                                                        <p class="text-xs text-gray-500">Head</p>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Sermons -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-semibold">Recent Sermons</h2>
                        <a href="{{ route('member.sermon') }}" class="text-sm text-primary hover:text-secondary">View
                            All</a>
                    </div>
                    <div class="sermon-list">
                        @include('admin.sermons.sermon-list')
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


            </div>
        </div>
    </main>
    </div>
    @vite('resources/js/admin-sermon-index.js');
@endsection