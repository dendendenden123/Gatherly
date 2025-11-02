@extends('layouts.member')
@section('content')
    @section('header')
        <header class="bg-gradient-to-r from-primary to-secondary shadow-lg">
            <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-white">My Attendance</h1>
                    <p class="text-white/80 text-sm mt-1">Track your participation history</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="text-white/90 hover:text-white transition">
                            <i class="bi bi-bell text-xl"></i>
                            <span class="notification-dot"></span>
                        </button>
                    </div>
                    <button class="md:hidden text-white/90 hover:text-white">
                        <i class="bi bi-list text-xl"></i>
                    </button>
                </div>
            </div>
        </header>
    @endsection

    <main class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <form method="GET" action="{{ route('my.attendance') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="time-period" class="block text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Period</label>
                        <select id="time-period" name="time_period"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition text-sm">
                            <option value="last_30_days" {{ (isset($filters['time_period']) && $filters['time_period'] === 'last_30_days') ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="last_3_months" {{ (isset($filters['time_period']) && $filters['time_period'] === 'last_3_months') ? 'selected' : '' }}>Last 3 Months</option>
                            <option value="last_6_months" {{ (isset($filters['time_period']) && $filters['time_period'] === 'last_6_months') ? 'selected' : '' }}>Last 6 Months</option>
                            <option value="this_year" {{ (isset($filters['time_period']) && $filters['time_period'] === 'this_year') ? 'selected' : '' }}>This Year</option>
                            <option value="all_time" {{ (isset($filters['time_period']) && $filters['time_period'] === 'all_time') ? 'selected' : '' }}>All Time</option>
                        </select>
                    </div>
                    <div>
                        <label for="service-type" class="block text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Event</label>
                        <select id="service-type" name="service_type"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition text-sm">
                            <option value="all" {{ (isset($filters['service_type']) && $filters['service_type'] === 'all') ? 'selected' : '' }}>All Events</option>
                            @if(isset($eventNames) && count($eventNames))
                                @foreach($eventNames as $name)
                                    <option value="{{ $name }}" {{ (isset($filters['service_type']) && $filters['service_type'] === $name) ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <label for="attendance-status" class="block text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide">Status</label>
                        <select id="attendance-status" name="attendance_status"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition text-sm">
                            <option value="all" {{ (isset($filters['attendance_status']) && $filters['attendance_status'] === 'all') ? 'selected' : '' }}>All</option>
                            <option value="present" {{ (isset($filters['attendance_status']) && $filters['attendance_status'] === 'present') ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ (isset($filters['attendance_status']) && $filters['attendance_status'] === 'absent') ? 'selected' : '' }}>Absent</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-gradient-to-r from-primary to-secondary hover:shadow-lg text-white px-6 py-2.5 rounded-lg w-full font-medium transition-all duration-200 transform hover:scale-105">
                            <i class="bi bi-funnel mr-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Attendance Records -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h2 class="text-lg font-bold text-gray-800">Records</h2>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($attendances as $attendance)
                    @php
                        $occ = $attendance->event_occurrence;
                        $event = $occ->event ?? null;
                        $occDate = optional($occ)->occurrence_date;
                        $day = $occDate ? $occDate->format('j') : optional($attendance->created_at)->format('j');
                        $mon = $occDate ? strtoupper($occDate->format('M')) : strtoupper(optional($attendance->created_at)->format('M'));
                        $isPresent = strtolower($attendance->status ?? '') === 'present';
                    @endphp
                    <div class="p-5 hover:bg-gray-50/50 transition-all duration-200 attendance-card group">
                        <div class="flex items-start gap-4">
                            <!-- Date Badge -->
                            <div class="{{ $isPresent ? 'bg-gradient-to-br from-green-400 to-green-600 text-white shadow-green-200' : 'bg-gradient-to-br from-gray-300 to-gray-500 text-white shadow-gray-200' }} w-16 h-16 rounded-xl shadow-md flex flex-col items-center justify-center flex-shrink-0 transform group-hover:scale-105 transition-transform">
                                <div class="text-xl font-bold">{{ $day }}</div>
                                <div class="text-xs opacity-90">{{ $mon }}</div>
                            </div>
                            
                            <!-- Main Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 text-lg">{{ $event->event_name ?? 'Event' }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="bi bi-calendar3"></i> {{ $occ->occurrence_date ? $occ->occurrence_date->format('F j, Y') : 'N/A' }}
                                        </p>
                                    </div>
                                    @if($isPresent)
                                        <span class="text-xs font-semibold bg-green-100 text-green-700 px-3 py-1.5 rounded-full whitespace-nowrap shadow-sm">
                                            <i class="bi bi-check-circle-fill mr-1"></i>Present
                                        </span>
                                    @else
                                        <span class="text-xs font-semibold bg-red-100 text-red-700 px-3 py-1.5 rounded-full whitespace-nowrap shadow-sm">
                                            <i class="bi bi-x-circle-fill mr-1"></i>Absent
                                        </span>
                                    @endif
                                </div>

                                <!-- Attendance Details Grid -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                    <!-- Event Time -->
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="bi bi-clock text-blue-600 text-sm"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs text-gray-500 leading-tight">Event Time</p>
                                            <p class="font-medium text-gray-900 truncate">{{ $occ->start_time_formatted ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <!-- Check-in Time -->
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="bi bi-box-arrow-in-right text-green-600 text-sm"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs text-gray-500 leading-tight">Check-in</p>
                                            <p class="font-medium text-gray-900 truncate">{{ $attendance->formatted_check_in_time }}</p>
                                        </div>
                                    </div>

                                    <!-- Attendance Method -->
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="bi bi-{{ $attendance->attendance_method === 'fingerprint' ? 'fingerprint' : ($attendance->attendance_method === 'online' ? 'wifi' : ($attendance->attendance_method === 'mobile' ? 'phone' : 'person')) }} text-purple-600 text-sm"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs text-gray-500 leading-tight">Method</p>
                                            <p class="font-medium text-gray-900 truncate capitalize">{{ $attendance->attendance_method ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <!-- Location -->
                                    @if($attendance->district || $attendance->locale)
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="bi bi-geo-alt text-orange-600 text-sm"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs text-gray-500 leading-tight">Location</p>
                                            <p class="font-medium text-gray-900 truncate">{{ $attendance->district ?? $attendance->locale ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Notes (if any) -->
                                @if($attendance->notes)
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <div class="flex items-start gap-2">
                                        <i class="bi bi-sticky text-gray-400 text-sm mt-0.5"></i>
                                        <p class="text-sm text-gray-600 italic">{{ $attendance->notes }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="text-gray-300 mb-3">
                            <i class="bi bi-inbox text-5xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No records found</p>
                        <p class="text-gray-400 text-sm mt-1">Try adjusting your filters</p>
                    </div>
                @endforelse
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold text-gray-900">{{ $attendances->count() }}</span> of <span class="font-semibold text-gray-900">{{ $attendances->total() }}</span>
                    </div>
                    <div>
                        {{ $attendances->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection