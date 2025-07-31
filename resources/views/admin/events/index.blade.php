@extends('layouts.admin')
@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #a5b4fc;
            --secondary: #f43f5e;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --success: #10b981;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem 2rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 0.5rem;
            padding: 0.5rem;
            padding-left: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray);
        }

        .card-value {
            font-size: 2rem;
            font-weight: 600;
            color: var(--dark);
        }

        .card-footer {
            font-size: 0.75rem;
            color: var(--gray);
        }

        .events-container {
            padding: 0 2rem 2rem;
        }

        .events-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .events-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .search-filter {
            display: flex;
            gap: 1rem;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            width: 240px;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .filter-btn {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .events-table {
            width: 100%;
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .events-table th {
            background-color: #f8fafc;
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .events-table td {
            padding: 1rem 1.5rem;
            border-top: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .event-name {
            font-weight: 500;
            color: var(--dark);
        }

        .event-type {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 9999px;
            background-color: #e0e7ff;
            color: var(--primary);
        }

        .event-datetime {
            display: flex;
            flex-direction: column;
        }

        .event-date {
            font-weight: 500;
        }

        .event-time {
            font-size: 0.875rem;
            color: var(--gray);
        }

        .event-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-upcoming {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        .status-ongoing {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-completed {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .edit-btn {
            background-color: #e0f2fe;
            color: #0ea5e9;
        }

        .edit-btn:hover {
            background-color: #bae6fd;
        }

        .delete-btn {
            background-color: #fee2e2;
            color: #ef4444;
        }

        .delete-btn:hover {
            background-color: #fecaca;
        }

        .view-btn {
            background-color: #e0e7ff;
            color: #6366f1;
        }

        .view-btn:hover {
            background-color: #c7d2fe;
        }

        .add-event-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s;
        }

        .add-event-btn:hover {
            transform: scale(1.05);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 0.5rem;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
        }

        .btn-outline {
            background-color: white;
            color: var(--dark);
            border: 1px solid #e2e8f0;
        }

        /* Occurrences Section */
        .occurrences-container {
            margin-top: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .occurrences-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .occurrences-title {
            font-size: 1.125rem;
            font-weight: 600;
        }

        .occurrences-table {
            width: 100%;
        }

        .occurrences-table th {
            background-color: #f8fafc;
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .occurrences-table td {
            padding: 0.75rem 1rem;
            border-top: 1px solid #f1f5f9;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge i {
            font-size: 0.625rem;
        }
    </style>
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