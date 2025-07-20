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
<main class="max-w-7xl mx-auto px-1 py-6 sm:px-6 lg:px-8">
    <form class="filter-form">
        <!-- Filters and Summary -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <!-- Start Date Filter -->

            <div class="bg-white p-4 rounded-lg shadow">
                <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Start Date </label>

                <input type="date" id="start_date" name="start_date"
                    class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700" />
            </div>

            <!-- End Date Filter -->
            <div class="bg-white p-4 rounded-lg shadow">
                <label for="month" class="block text-sm font-medium text-gray-700 mb-1">End Date </label>
                <input type="date" id="end_date" name="end_date"
                    class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700" />
            </div>

            <!-- Service Type Filter -->
            <div class="bg-white p-4 rounded-lg shadow">
                <label for="service-type" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status"
                    class="status w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                    <option value="*">All</option>
                    <option value="present">
                        Present
                    </option>
                    <option value="absent">
                        Absent
                    </option>
                </select>
            </div>

            <!-- Service Type Filter -->
            <div class="bg-white p-4 rounded-lg shadow">
                <label for="service-type" class="block text-sm font-medium text-gray-700 mb-1">Specify Event</label>
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

    <!-- Individual Attendance -->
    <div class="min-h-screen bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold">Member Attendance</h2>
            <div class="flex items-center space-x-2">
                <form class="filter-name">
                    <input type="text" name="search"
                        class="search-box border border-gray-300 rounded-md px-3 py-1 text-sm"
                        placeholder="Search members...">
                    <button class="clear-search bg-primary hover:bg-secondary text-white px-3 py-1 rounded-md text-sm">
                        <i class="bi bi-plus mr-1"></i> Clear
                    </button>
                </form>
            </div>
        </div>
        <div class="index-attendance-list overflow-x-auto">
            @include('admin.attendance.index-attendance-list')
        </div>
    </div>

</main>
<script>
    $(document).ready(function () {
        let ajaxRequest = null;
        let debounceTimer = null;

        function requestData() {
            const filterForm = $('.filter-form').serialize();
            const filterName = $('.filter-name').serialize();
            const combinedForm = filterForm + '&' + filterName;
            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(() => {
                if (ajaxRequest) {
                    ajaxRequest.abort();
                }
                ajaxRequest = $.ajax({
                    url: "/admin/attendance",
                    type: 'GET',
                    data: combinedForm,
                    success: function (data) {
                        $('.index-attendance-list').html(data);
                    },
                    error: function (xhr) {
                        console.error("Error:", xhr.responseText);
                    }
                });
            }, 300)

        }

        $(document).on('input change', '.search-box, .filter-name, .filter-form', requestData);
        $('.clear-search').on('click', function (e) {
            e.preventDefault();
            $(".search-box").val('');
            requestData();
        });

    });
</script>
@endSection