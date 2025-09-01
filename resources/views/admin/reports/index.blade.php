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
                    <option value="monthly"> Monthly</option>
                    <option value="weekly"> Weekly</option>
                    <option value="yearly"> Yearly</option>

                </select>
            </div>

            <!-- Start Date Filter -->
            <div class=" rounded-lg   max-w-48">
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date
                </label>

                <input type="date" id="start_date" name="start_date"
                    class="border border-gray-300 rounded-md px-2 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700" />
            </div>

            <!-- End Date Filter -->
            <div class=" rounded-lg   max-w-48">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date </label>
                <input type="date" id="end_date" name="end_date"
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
                        <option value="{{ $event->id }}">
                            {{ $event->event_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="report-actions">
            <button class="btn btn-outline">
                <i class="fas fa-filter"></i> Filter
            </button>
            <button class="btn btn-primary" id="generateReportBtn">
                <i class="fas fa-file-export"></i> Export
            </button>
        </div>
    </form>
</div>

@endSection

@section('content')
<div class="chart-container">
    @include('admin.reports.index-chart')
</div>
@vite('resources/js/admin-reports-index.js')
@endSection