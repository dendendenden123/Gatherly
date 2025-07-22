@extends("layouts.admin")

@section('content')
    <!-- Main Content -->
    <main class="flex-grow bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <!-- Page Header -->
            @section('header')
                <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Attendance History</h1>
                        <p class="text-gray-500 mt-1">Detailed attendance records and analytics</p>
                    </div>
                    <div class="flex space-x-3">
                        <button onclick="window.history.back()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </button>

                        <select id="service-type" name="event_id"
                            class="size-[60%] border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                            <option value="">All Services</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}">
                                    {{ $event->event_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endsection

            <!-- User Profile Section -->
            <div class="mb-8">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 flex items-center">
                        <img class="h-20 w-20 rounded-full ring-4 ring-emerald-100"
                            src="https://ui-avatars.com/api/?name={{ urlencode($user->first_name . ' ' . $user->last_name) }}&background=10b981&color=fff"
                            alt="User avatar">
                        <div class="ml-6">
                            <h3 class="text-2xl font-semibold text-gray-800">{{ $user->first_name }} {{ $user->last_name }}
                            </h3>
                            <p class="text-gray-500 mt-1">Member since: {{ $user->created_at->format('F Y') }}</p>
                            <div class="flex mt-3 space-x-2">
                                <span
                                    class="bg-emerald-50 text-emerald-700 text-xs font-medium px-3 py-1 rounded-full">{{ $user->status }}</span>
                                <span
                                    class="bg-blue-50 text-blue-700 text-xs font-medium px-3 py-1 rounded-full">Volunteer</span>
                            </div>
                        </div>
                        <div class="ml-auto flex space-x-4">
                            <div class="text-center px-4 py-2">
                                <p class="text-gray-500 text-sm">Age</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $user->birthdate->age }}</p>
                            </div>
                            <div class="text-center px-4 py-2">
                                <p class="text-gray-500 text-sm">Group</p>
                                <p class="text-lg font-semibold text-gray-800">
                                    @php
                                        $age = $user->birthdate->age;
                                        if ($age < 18) {
                                            $ageGroup = "Binhi Youth";
                                        } else if ($age >= 18 && $user->marital_status != "married") {
                                            $ageGroup = "Kadiwa Youth";
                                        } else if ($age >= 18 && $user->marital_status == "married") {
                                            $ageGroup = "Buklod/Married";
                                        }
                                    @endphp
                                    {{  $ageGroup  }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Attendance -->
                <div
                    class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Attendance</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">
                                {{ $countTotalAttendance }}
                            </p>
                        </div>
                        <div class="bg-emerald-100 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $percentageDifferentFromLastMonth['value'] }}% growth in the month of
                            {{ now()->subMonth()->format('F') }}
                        </span>
                    </div>
                </div>

                <!-- Current Streak -->
                <div
                    class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Current Streak</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">6</p>
                        </div>
                        <div class="bg-orange-100 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-gray-500">Consecutive weeks attended</div>
                    </div>
                </div>

                <!-- Attendance Rate -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Attendance Rate</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">85%</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                    clip-rule="evenodd" />
                            </svg>
                            5% vs last quarter
                        </span>
                    </div>
                </div>

                <!-- Average Attendance -->
                <div
                    class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Avg. Monthly</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">3.2</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-gray-500">Average sessions per month</div>
                    </div>
                </div>
            </div>

            <!-- Attendance Chart (Placeholder) -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Attendance Trend</h3>
                    <select
                        class="bg-gray-50 border border-gray-300 text-gray-700 py-1 px-3 rounded-lg focus:ring-emerald-500 focus:border-emerald-500">
                        <option>Last 6 months</option>
                        <option>Last year</option>
                        <option>All time</option>
                    </select>
                </div>
                <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                    <p class="text-gray-400">Attendance chart visualization</p>
                </div>
            </div>

            <!-- Attendance Table -->
            <div class="show-attendance-list">
                @include('admin.attendance.show-attendance-list')
            </div>
        </div>
    </main>
@endsection