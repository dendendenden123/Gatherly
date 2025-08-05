@extends('layouts.admin')
@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css\admin\events\index.css') }}" rel="stylesheet">
@endsection

@section('header')
<!-- Header -->
<header>
    <div class="max-w-7xl mx-auto px-4 py-1 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="page-tite">
            <h1 class="text-xl font-semibold text-gray-900">Events Management</h1>
            <p class="text-gray-500">Efficiently monitor event progress and participation</p>
        </div>


        <div class="flex items-center space-x-4">
            <a href=" {{ route('admin.events.create') }}">
                <button
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="bi bi-plus mr-1"></i> New Event
                </button>
            </a>
        </div>
    </div>
</header>
@endSection


@section('content')
    <!-- Dashboard Cards -->
    <div class="dashboard-cards">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-title">Total Events</div>
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="card-value">{{ $totalEvents }}</div>
            <div class="card-footer">All events</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-title">Upcoming Events</div>
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="card-value">{{ $upcomingEvents }}</div>
            <div class="card-footer">Next 30 days</div>
        </div>

    </div>

    <!-- Events Table -->
    <div class="events-container">
        <div class="events-header flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <h2 class="events-title text-2xl md:text-xl  text-gray-800">All Events</h2>

            <div class="search-filter w-full md:w-auto flex flex-col-reverse md:flex-row gap-4 items-start md:items-center">
                <form class="filter-form w-full md:w-auto flex flex-col md:flex-row gap-3" method="GET"
                    action="{{ route('admin.events.index') }}">
                    <div class="relative">
                        <select name="event_type"
                            class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value='' class="text-gray-500">Event Type <i>(All)</i></option>
                            <option value='Baptism'>Baptism</option>
                            <option value="Charity Event">Charity Event</option>
                            <option value="Christian Family Organization (CFO) activity">Christian Family Organization (CFO)
                                activity</option>
                            <option value="Evangelical Mission">Evangelical Mission</option>
                            <option value="Inauguration of New Chapels/ Structure">Inauguration of New Chapels/ Structure
                            </option>
                            <option value="Meeting">Meeting</option>
                            <option value="Panata">Panata</option>
                            <option value="Weddings">Weddings</option>
                            <option value="Worship Service">Worship Service</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select name='status'
                            class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value='' class="text-gray-500">Status <i>(All)</i> </option>
                            <option value="Upcoming">Upcoming</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>

                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" placeholder="Search events..." id="searchInput" name="event_name"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    </div>
                </form>

                <button type="submit"
                    class="bulk-delete-submit-btn flex items-center px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Selected
                </button>
            </div>
        </div>
        <div class='index-events-list'>
            @include('admin.events.index-events-list')
        </div>
    </div>
    @vite('resources/js/admin-events-index.js')
@endsection