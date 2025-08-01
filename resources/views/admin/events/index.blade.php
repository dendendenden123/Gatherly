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
                <button class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md text-sm">
                    <i class="bi bi-plus mr-1"></i> New Record
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

        <div class="events-header">
            <h2 class="events-title">All Events</h2>
            <div class="search-filter">
                <button type="submit"
                    class="bulk-delete-submit-btn flex items-center px-3 py-1  text-gray-500 rounded text-lg">
                    <i class="fas fa-trash mr-1"></i> Delete
                </button>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <form class='filter-form' method="GET" action=" {{ route('admin.events.index') }}">
                        <input type="text" placeholder="Search events..." id="searchInput" name='event_name'>
                    </form>
                </div>
            </div>

        </div>
        <div class='index-events-list'>
            @include('admin.events.index-events-list')
        </div>
    </div>
    @vite('resources/js/admin-events-index.js')
@endsection