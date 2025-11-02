@extends('layouts.member')

@section('styles')
    <!-- Video.js CSS -->
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
    
    <style>
        .video-js {
            width: 100% !important;
            height: 192px !important; /* h-48 equivalent */
        }

        .sermon-thumbnail {
            position: relative;
            height: 192px;
            background: #000;
        }

        .sermon-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endsection

@section('scripts')
    <!-- Video.js JS -->
    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
@endsection

@section('header')
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900">Sermons</h1>
            <p class="text-sm text-gray-500">Explore our library of biblical teachings</p>
        </div>
    </header>
@endsection

@section('header')
    <header>
        <div class="max-w-7xl mx-auto px-4 py-1 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="page-tite">
                <h1 class="text-xl font-semibold text-gray-900">Sermon Video Library</h1>
                <p class="text-gray-500">Upload sermons seamlessly and stay updated.
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.sermons.create') }}">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm flex items-center">
                        <i class="bi bi-plus mr-1"></i>Add New Sermon
                    </button>
                </a>
            </div>
    </header>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-6">
        <div class="filter-bar rounded-lg shadow p-4 mb-8">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="relative flex-1">
                    <input type="text" id="search-input" placeholder="Search sermon by name..." value="{{ request('search') }}"
                        class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <select id="date-filter"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="" {{ request('date') === null || request('date') === '' ? 'selected' : '' }}>All Dates
                    </option>
                    <option value="recent" {{ request('date') === 'recent' ? 'selected' : '' }}>Recent First</option>
                    <option value="oldest" {{ request('date') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="last-month" {{ request('date') === 'last-month' ? 'selected' : '' }}>Last Month</option>
                    <option value="last-3-months" {{ request('date') === 'last-3-months' ? 'selected' : '' }}>Last 3 Months
                    </option>
                    <option value="2023" {{ request('date') === '2023' ? 'selected' : '' }}>2023</option>
                    <option value="2022" {{ request('date') === '2022' ? 'selected' : '' }}>2022</option>
                </select>
            </div>
        </div>

        <div class="sermon-list">
            @include('admin.sermons.sermon-list')
        </div>
    </div>
    @vite('resources/js/admin-sermon-index.js');
@endsection