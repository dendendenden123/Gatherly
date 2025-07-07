@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/attendance/index.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
@endsection


@section('header')
<!-- Header -->
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-900">Attendance Tracking</h1>
        <div class="flex items-center space-x-4">
            <button class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md text-sm">
                <i class="bi bi-plus mr-1"></i> New Record
            </button>
        </div>
    </div>
</header>
@endSection

@section('content')

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <!-- Filters and Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Date Filter -->
        <div class="bg-white p-4 rounded-lg shadow">
            <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Month</label>
            <select id="month"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                <option>June 2023</option>
                <option>May 2023</option>
                <option>April 2023</option>
            </select>
        </div>

        <!-- Member Type Filter -->
        <div class="bg-white p-4 rounded-lg shadow">
            <label for="member-type" class="block text-sm font-medium text-gray-700 mb-1">Member Type</label>
            <select id="member-type"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                <option>All Members</option>
                <option>Adults Only</option>
                <option>Children Only</option>
                <option>Volunteers</option>
            </select>
        </div>

        <!-- Service Type Filter -->
        <div class="bg-white p-4 rounded-lg shadow">
            <label for="service-type" class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
            <select id="service-type"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                <option>All Services</option>
                <option>Sunday Morning</option>
                <option>Wednesday Night</option>
                <option>Special Events</option>
            </select>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white p-4 rounded-lg shadow flex items-center">
            <div class="flex-1">
                <p class="text-sm text-gray-500">Monthly Attendance</p>
                <h3 class="text-2xl font-bold">78%</h3>
                <p class="text-xs text-gray-500">+5% from last month</p>
            </div>
            <div class="relative w-16 h-16">
                <svg class="w-full h-full" viewBox="0 0 36 36">
                    <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="3"></circle>
                    <circle cx="18" cy="18" r="16" fill="none" stroke="#2ecc71" stroke-width="3" stroke-dasharray="100"
                        stroke-dashoffset="22" class="progress-ring__circle"></circle>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="bi bi-people text-primary text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold">Recent Attendance</h2>
            <div class="flex items-center space-x-2">
                <button class="text-gray-500 hover:text-primary">
                    <i class="bi bi-printer"></i>
                </button>
                <button class="text-gray-500 hover:text-primary">
                    <i class="bi bi-download"></i>
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Service</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Present</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            First Timers</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Volunteers</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Children</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Sun, Jun 11</div>
                            <div class="text-sm text-gray-500">10:30 AM</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Sunday
                                Service</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">142</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">3</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">22</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">28</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-primary hover:text-secondary mr-3">Edit</button>
                            <button class="text-gray-500 hover:text-gray-700">Details</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Wed, Jun 7</div>
                            <div class="text-sm text-gray-500">7:00 PM</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">Bible
                                Study</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">87</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">1</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">15</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">12</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-primary hover:text-secondary mr-3">Edit</button>
                            <button class="text-gray-500 hover:text-gray-700">Details</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Sun, Jun 4</div>
                            <div class="text-sm text-gray-500">10:30 AM</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Sunday
                                Service</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">135</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">5</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">20</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">25</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-primary hover:text-secondary mr-3">Edit</button>
                            <button class="text-gray-500 hover:text-gray-700">Details</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Fri, Jun 2</div>
                            <div class="text-sm text-gray-500">6:00 PM</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Youth
                                Night</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">42</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">2</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">8</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">0</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-primary hover:text-secondary mr-3">Edit</button>
                            <button class="text-gray-500 hover:text-gray-700">Details</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Showing <span class="font-medium">1</span> to <span class="font-medium">4</span> of <span
                    class="font-medium">12</span> records
            </div>
            <div class="flex space-x-2">
                <button
                    class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </button>
                <button
                    class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </button>
            </div>
        </div>
    </div>

    <!-- Individual Attendance -->
    <div class="min-h-screen bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold">Member Attendance</h2>
            <div class="flex items-center space-x-2">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <div class="relative">
                        <select
                            class="appearance-none bg-light-gray border-0 text-gray-700 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-green">
                            <option>Filter</option>
                            <option>Status</option>
                            <option>Last 3 months</option>
                            <option>Last 6 months</option>
                            <option>Last year</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
                <form class="search-member-form">
                    <input type="text" name="search"
                        class="search-box border border-gray-300 rounded-md px-3 py-1 text-sm"
                        placeholder="Search members...">
                </form>
            </div>
        </div>
        <div class="member-attendance-list overflow-x-auto">
            @include('admin.attendance.member-attendance-list')
        </div>
    </div>
</main>


<script>

    //search
    $(document).on('input change', '.search-member-form .search-box', function (e) {
        e.preventDefault();
        $.ajax({
            url: "/admin/attendance",
            type: 'GET',
            data: {
                query: $('.search-member-form .search-box').val()
            },
            success: function (data) {
                $('.member-attendance-list').html(data);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    });
</script>
@endSection