@extends('layouts.admin')

@section('styles')
    <link href="{{ asset('css/admin/reports.css') }}" rel="stylesheet">
@endsection

@section('header')
<div class="reports-header">
    <div class="reports-title">
        <h1>Reports Dashboard</h1>
        <p>Analyze and export church data and metrics</p>
    </div>

    <form id="filterForm" action='{{ route('admin.reports') }}' class="report-controls">
        <!-- filters -->
        <div class="flex  justify-end gap-6 mb-6">
            <div class=" rounded-lg   max-w-48">
                <label for="aggregate" class="block text-sm font-medium text-gray-700 mb-1">Aggregation</label>
                <select id="aggregate" name="aggregate"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                    <option value="monthly" {{ request('aggregate', 'monthly') === 'monthly' ? 'selected' : '' }}> Monthly
                    </option>
                    <option value="weekly" {{ request('aggregate') === 'weekly' ? 'selected' : '' }}> Weekly</option>
                    <option value="yearly" {{ request('aggregate') === 'yearly' ? 'selected' : '' }}> Yearly</option>

                </select>
            </div>

            <!-- Start Date Filter -->
            <div class=" rounded-lg   max-w-48">
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date
                </label>

                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                    class="border border-gray-300 rounded-md px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700" />
            </div>

            <!-- End Date Filter -->
            <div class=" rounded-lg   max-w-48">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date </label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                    class="border border-gray-300 rounded-md px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700" />
            </div>


            <!-- Service Type Filter -->
            <div class=" rounded-lg  max-w-48">
                <label for="service-type" class="block text-sm font-medium text-gray-700 mb-1">Specify
                    Event</label>
                <select id="service-type" name="event_id"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                    <option value="">All Services</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" {{ (string) request('event_id') === (string) $event->id ? 'selected' : '' }}>
                            {{ $event->event_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Attendance Status Filter -->
            <div class=" rounded-lg   max-w-48">
                <label for="attendance_status" class="block text-sm font-medium text-gray-700 mb-1">Type of
                    User</label>
                <select id="attendance_status" name="attendance_status"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                    <option value="" {{ request('attendance_status') === '' ? 'selected' : '' }}>All</option>
                    <option value="present" {{ request('attendance_status') === 'present' ? 'selected' : '' }}>Present
                    </option>
                    <option value="absent" {{ request('attendance_status') === 'absent' ? 'selected' : '' }}>Absent
                    </option>
                </select>
            </div>
        </div>

        <div class="report-actions flex items-center gap-3">
            <button type="button" class="btn btn-outline" id="applyFiltersBtn">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a class="btn btn-primary" id="exportAttendanceBtn" href="{{ route('admin.reports.attendance.print') }}"
                data-base="{{ route('admin.reports.attendance.print') }}">
                <i class="fas fa-file-export"></i> Export PDF
            </a>
        </div>
    </form>
</div>

@endSection

@section('content')
<div class="chart-container">
    @include('admin.reports.index-chart')
</div>

<div class="mt-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Attendance List</h2>
    <div id="attendanceListContainer" class="bg-white rounded-lg border border-gray-200"
        data-url="{{ route('admin.reports.attendance.list') }}">
        <div class="p-6 text-gray-500 text-sm">Use the filters to load attendance list.</div>
    </div>
    <div class="mt-2 text-xs text-gray-500">Max 500 rows shown.</div>
    <template id="attendanceListEmptyTemplate">
        <div class="p-6 text-gray-500 text-sm">No records found for selected filters.</div>
    </template>
    <template id="attendanceListErrorTemplate">
        <div class="p-6 text-red-600 text-sm">Failed to load attendance list.</div>
    </template>
    <template id="attendanceListLoadingTemplate">
        <div class="p-6 text-gray-500 text-sm">Loading...</div>
    </template>
</div>
@vite(['resources/js/admin-reports-index.js', 'resources/js/admin-reports-list.js'])
@endSection