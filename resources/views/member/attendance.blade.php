@extends('layouts.member')
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
                        <h3 class="text-2xl font-bold">{{ $monthlyAttendancePct ?? 0 }}%</h3>
                        <p class="text-xs text-gray-500">
                            @php $delta = $monthlyAttendanceDelta ?? 0; @endphp
                            {{ $delta >= 0 ? '+' : '' }}{{ $delta }}% from last month
                        </p>
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
            <form method="GET" action="{{ route('attendance') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="time-period" class="block text-sm font-medium text-gray-700 mb-1">Time
                            Period</label>
                        <select id="time-period" name="time_period"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                            <option value="last_30_days" {{ (isset($filters['time_period']) && $filters['time_period']==='last_30_days') ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="last_3_months" {{ (isset($filters['time_period']) && $filters['time_period']==='last_3_months') ? 'selected' : '' }}>Last 3 Months</option>
                            <option value="last_6_months" {{ (isset($filters['time_period']) && $filters['time_period']==='last_6_months') ? 'selected' : '' }}>Last 6 Months</option>
                            <option value="this_year" {{ (isset($filters['time_period']) && $filters['time_period']==='this_year') ? 'selected' : '' }}>This Year</option>
                            <option value="all_time" {{ (isset($filters['time_period']) && $filters['time_period']==='all_time') ? 'selected' : '' }}>All Time</option>
                        </select>
                    </div>
                    <div>
                        <label for="service-type" class="block text-sm font-medium text-gray-700 mb-1">Service
                            Type</label>
                        <select id="service-type" name="service_type"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                            <option value="all" {{ (isset($filters['service_type']) && $filters['service_type']==='all') ? 'selected' : '' }}>All Services</option>
                            @if(isset($eventNames) && count($eventNames))
                                @foreach($eventNames as $name)
                                    <option value="{{ $name }}" {{ (isset($filters['service_type']) && $filters['service_type'] === $name) ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <label for="attendance-status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="attendance-status" name="attendance_status"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                            <option value="all" {{ (isset($filters['attendance_status']) && $filters['attendance_status']==='all') ? 'selected' : '' }}>All Attendance</option>
                            <option value="present" {{ (isset($filters['attendance_status']) && $filters['attendance_status']==='present') ? 'selected' : '' }}>Present Only</option>
                            <option value="absent" {{ (isset($filters['attendance_status']) && $filters['attendance_status']==='absent') ? 'selected' : '' }}>Absent Only</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md w-full">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Detailed Attendance List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold">Attendance History</h2>
                <div class="text-sm text-gray-500">Showing last 10 records</div>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($attendances as $attendance)
                    @php
                        $occ = $attendance->event_occurrence;
                        $event = $occ->event ?? null;
                        $occDate = optional($occ)->occurrence_date;
                        $day = $occDate ? $occDate->format('j') : optional($attendance->created_at)->format('j');
                        $mon = $occDate ? strtoupper($occDate->format('M')) : strtoupper(optional($attendance->created_at)->format('M'));
                        $isPresent = strtolower($attendance->status ?? '') === 'present';
                    @endphp
                    <div class="p-4 hover:bg-gray-50 transition attendance-card">
                        <div class="flex items-start">
                            <div class="{{ $isPresent ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} p-2 rounded text-center mr-4 flex-shrink-0">
                                <div class="text-sm font-bold">{{ $day }}</div>
                                <div class="text-xs">{{ $mon }}</div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h3 class="font-medium">{{ $event->event_name ?? 'Event' }}</h3>
                                    @if($isPresent)
                                        <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded-full">Present</span>
                                    @else
                                        <span class="text-sm bg-red-100 text-red-800 px-2 py-1 rounded-full">Absent</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 mt-1">{{ $occ->start_time_formatted ?? 'N/A' }}</p>
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
                @empty
                    <div class="p-6 text-center text-gray-500">No attendance records found for the selected filters.</div>
                @endforelse
            </div>
            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <div>
                        Showing {{ $attendances->count() }} of {{ $attendances->total() }} records
                    </div>
                    <div>
                        {{ $attendances->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection