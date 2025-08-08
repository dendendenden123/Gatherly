@extends('layouts.admin')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin/events/show.css') }}" rel="stylesheet">
@endsection

@section('header')
    <!-- Header -->
    <header>
        <div class="max-w-7xl mx-auto px-4 py-1 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="page-title">
                <h1 class="text-xl font-semibold text-gray-900">Event Details</h1>
                <p class="text-gray-500">View and manage event information and occurrences</p>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.events.edit', $event->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                    <i class="bi bi-pencil mr-2"></i> Edit Event
                </a>
                <a href="{{ route('admin.events.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="bi bi-arrow-left mr-2"></i> Back to Events
                </a>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Event Summary Cards -->
        <div class="dashboard-cards grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="dashboard-card bg-white rounded-lg shadow p-6">
                <div class="card-header flex justify-between items-center mb-4">
                    <div class="card-title text-gray-500 font-medium">Event Type</div>
                    <i class="fas fa-tag text-blue-500"></i>
                </div>
                <div class="card-value text-2xl font-semibold text-gray-800">{{ $event->event_type }}</div>
            </div>

            <div class="dashboard-card bg-white rounded-lg shadow p-6">
                <div class="card-header flex justify-between items-center mb-4">
                    <div class="card-title text-gray-500 font-medium">Volunteers Needed</div>
                    <i class="fas fa-users text-green-500"></i>
                </div>
                <div class="card-value text-2xl font-semibold text-gray-800">{{ $event->number_Volunteer_needed }}</div>
            </div>

            <div class="dashboard-card bg-white rounded-lg shadow p-6">
                <div class="card-header flex justify-between items-center mb-4">
                    <div class="card-title text-gray-500 font-medium">Occurrences</div>
                    <i class="fas fa-calendar-day text-purple-500"></i>
                </div>
                <div class="card-value text-2xl font-semibold text-gray-800">{{ $eventOccurrences->count() }}</div>
            </div>
        </div>

        <!-- Event Details -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Event Information</h2>
            </div>

            <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Event Name</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $event->event_name }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Description</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $event->event_description }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Location</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $event->location }}</p>
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Date Range</h3>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($event->start_date)->format('M j, Y') }} -
                            {{ \Carbon\Carbon::parse($event->end_date)->format('M j, Y') }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Time</h3>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} -
                            {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <span
                            class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                        {{ $event->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Occurrences -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">Event Occurrences</h2>
                <a
                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="bi bi-plus mr-1"></i> Add Occurrence
                </a>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse($eventOccurrences as $occurrence)
                    <div class="px-6 py-4 hover:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center mb-3 md:mb-0">
                                <div
                                    class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <i class="bi bi-calendar-event text-indigo-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($occurrence->occurrence_date)->format('l, F j, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($occurrence->start_time)->format('g:i A') }} -
                                        {{ \Carbon\Carbon::parse($occurrence->end_time)->format('g:i A') }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                                                            {{ $occurrence->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($occurrence->status) }}
                                </span>

                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                                                            {{ $occurrence->attendance_checked ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $occurrence->attendance_checked ? 'Attendance Checked' : 'Pending Check' }}
                                </span>

                                <div class="flex space-x-2">
                                    <a class="text-blue-600 hover:text-blue-900">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center">
                        <i class="bi bi-calendar-x text-4xl text-gray-400 mb-3"></i>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No occurrences scheduled</h3>
                        <p class="mt-1 text-sm text-gray-500">This event doesn't have any scheduled occurrences yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/admin/events/show.js')
@endsection