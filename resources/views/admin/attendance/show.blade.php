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
        <div class="show-attendance-list">
            @include('admin.attendance.show-attendance-list')
        </div>
    </div>
</main>
@endSection