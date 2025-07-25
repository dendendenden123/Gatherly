@extends("layouts.admin")

@section('content')
    <!-- Main Content -->
    <main class="flex-grow bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <!-- Page Header -->
            @section('header')
                <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl text-xl font-bold text-gray-800">Attendance History</h1>
                        <p class="text-gray-500  tex-lg mt-1">Detailed attendance records and analytics</p>
                    </div>
                    <div class="flex space-x-3">
                        <button onclick="window.history.back()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>

                        </button>
                    </div>
                </div>
            @endsection

            <!-- User Profile Section -->
            <div class="mb-8">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 flex items-center">
                        <img class="h-sm w-sm rounded-full ring-4 ring-emerald-100 "
                            src="https://ui-avatars.com/api/?name={{ urlencode($user->first_name . ' ' . $user->last_name) }}&background=10b981&color=fff"
                            alt="User avatar">
                        <div class="ml-6">
                            <h3 class="text-sm font-semibold text-gray-800">{{ $user->first_name }} {{ $user->last_name }}
                            </h3>
                            <p class="text-gray-500 mt-1 text-sm">Member since: {{ $user->created_at->format('F Y') }}</p>
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
                                <p class="text-sm font-semibold text-gray-800">{{ $user->birthdate->age }}</p>
                            </div>
                            <div class="text-center px-4 py-2">
                                <p class="text-gray-500 text-sm">Group</p>
                                <p class="text-sm font-semibold text-gray-800">
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
                <!-- Total Attendance -->
                <div
                    class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Attendance</p>
                            <p class="text-lg font-bold text-gray-800 mt-1">
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
                        @if($attendanceGrowthRateLastMonth['sign'] === 'positive')
                            <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $attendanceGrowthRateLastMonth['value'] }}% growth in the month of
                                {{ now()->subMonth()->format('F') }}
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 text-sm px-2 py-1 rounded-full flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 transform rotate-180"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                        clip-rule="evenodd" />
                                </svg>

                                {{ $attendanceGrowthRateLastMonth['value'] }}% decline in the month of
                                {{ now()->subMonth()->format('F') }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Attendance Rate -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Attendance Rate
                                ({{ now()->subMonth()->format('F') }})
                            </p>
                            <p class="text-lg font-bold text-gray-800 mt-1">{{ $attendanceRateLastMonth }}%</p>
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
                        <span class="bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded-full flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 mr-1 {{ $attendanceGrowthRateLastMonth['sign'] === 'negative' ? 'rotate-180' : '' }}"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $attendanceGrowthRateLastMonth['value'] }}% compared to
                            {{ now()->subMonths(2)->format('F') }}
                        </span>
                    </div>
                </div>
            </div>


            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Attendance Trend</h3>

                    <form method="GET" id="filter-form" action="{{ route('admin.attendance.show', $user->id) }}">
                        <!-- filters -->
                        <div class="flex  justify-end gap-6 mb-6">
                            <div class="bg-white rounded-lg   max-w-48">
                                <label for="aggregate"
                                    class="block text-sm font-medium text-gray-700 mb-1">Aggregation</label>
                                <select id="aggregate" name="aggregate"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                                    <option value="monthly"> Monthly</option>
                                    <option value="weekly"> Weekly</option>
                                    <option value="yearly"> Yearly</option>

                                </select>
                            </div>

                            <!-- Start Date Filter -->
                            <div class="bg-white rounded-lg   max-w-48">
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date
                                </label>

                                <input type="date" id="start_date" name="start_date"
                                    class="border border-gray-300 rounded-md px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700" />
                            </div>

                            <!-- End Date Filter -->
                            <div class="bg-white rounded-lg   max-w-48">
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date </label>
                                <input type="date" id="end_date" name="end_date"
                                    class="border border-gray-300 rounded-md px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700" />
                            </div>


                            <!-- Service Type Filter -->
                            <div class="bg-white rounded-lg  max-w-48">
                                <label for="service-type" class="block text-sm font-medium text-gray-700 mb-1">Specify
                                    Event</label>
                                <select id="service-type" name="event_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                                    <option value="">All Services</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}">
                                            {{ $event->event_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Attendance Chart (Placeholder) -->
                <div class="chart-container" style="position: relative; height: 400px; width: 100%;">
                    @include('admin.attendance.show-attendance-chart');
                </div>
            </div>

            <!-- Attendance Table -->
            <div class="show-attendance-list">
                @include('admin.attendance.show-attendance-list')
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function () {
            let ajaxRequest = null;
            let debounceTimer = null;

            // Debounced AJAX request
            function requestData() {
                const filterForm = $('#filter-form').serialize();
                clearTimeout(debounceTimer);

                debounceTimer = setTimeout(() => {
                    if (ajaxRequest) {
                        ajaxRequest.abort();
                    }

                    ajaxRequest = $.ajax({
                        url: $('#filter-form').attr('action'),
                        type: "GET",
                        data: filterForm,
                        success: function (data) {
                            $(".show-attendance-list").html(data.list);
                            $(".chart-container").html(data.chart);
                            renderAttendanceChart()
                        },
                        error: function (xhr) {
                            console.error("Error:", xhr.responseText);
                        }
                    });
                }, 300);
            }

            // Watch filter form for changes
            $('#filter-form').on("input change", requestData);

            // Initial render
            renderAttendanceChart();
        });
    </script>

@endsection