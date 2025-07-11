@extends("layouts.admin")

@section('header')
<!-- Header -->
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="flex items-center">
            <i class="fas fa-church text-primary-green text-2xl mr-3"></i>
            <h1 class="text-xl font-semibold text-gray-800">Gatherly</h1>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <img class="h-8 w-8 rounded-full"
                    src="https://ui-avatars.com/api/?name=John+Doe&background=2ecc71&color=fff" alt="User">
            </div>
        </div>
    </div>
</header>
@endSection

@section('content')
<!-- Main Content -->
<main class="flex-grow">
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Attendance History</h2>
                    <p class="text-gray-600">View and manage member attendance records</p>
                </div>
                <div class="flex space-x-3">
                    <button
                        class="bg-primary-green hover:bg-dark-green text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-download mr-2"></i> Export
                    </button>
                    <button
                        class="bg-white border border-primary-green text-primary-green hover:bg-light-gray px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
            </div>

            <!-- User Info Card -->
            <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <img class="h-16 w-16 rounded-full mr-4"
                        src="https://ui-avatars.com/api/?name=John+Doe&background=2ecc71&color=fff" alt="User">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $user->first_name }}</h3>
                        <p class="text-gray-600">Member since: January 2020</p>
                        <div class="flex mt-1">
                            <span class="bg-light-gray text-dark-green text-xs px-2 py-1 rounded mr-2">Active
                                Member</span>
                            <span class="bg-light-gray text-gray-600 text-xs px-2 py-1 rounded">Volunteer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Attendance</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">142</p>
                    </div>
                    <div class="bg-primary-green bg-opacity-10 p-3 rounded-full">
                        <i class="fas fa-calendar-check text-primary-green text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <span class="text-primary-green">↑ 12%</span>
                        <span class="ml-1">vs last month</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Current Streak</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">6</p>
                    </div>
                    <div class="bg-primary-green bg-opacity-10 p-3 rounded-full">
                        <i class="fas fa-fire text-primary-green text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <span>Weeks in a row</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Attendance Rate</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">85%</p>
                    </div>
                    <div class="bg-primary-green bg-opacity-10 p-3 rounded-full">
                        <i class="fas fa-percent text-primary-green text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <span class="text-primary-green">↑ 5%</span>
                        <span class="ml-1">vs last quarter</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-800">Recent Attendance</h3>
                <div class="relative">
                    <select
                        class="appearance-none bg-light-gray border-0 text-gray-700 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-green">
                        <option>Last 30 days</option>
                        <option>Last 3 months</option>
                        <option>Last 6 months</option>
                        <option>Last year</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
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
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Checked In</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Notes</th>
                        </tr>
                    </thead>
                    <tbody class="show-attendance-list bg-white divide-y divide-gray-200">
                        @include('admin.attendance.show-attendance-list')
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous </a>
                    <a href="#"
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Next </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">1</span>
                            to
                            <span class="font-medium">5</span>
                            of
                            <span class="font-medium">24</span>
                            entries
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="#" aria-current="page"
                                class="z-10 bg-primary-green border-primary-green text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                1 </a>
                            <a href="#"
                                class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                2 </a>
                            <a href="#"
                                class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                3 </a>
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endSection