@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/attendance/index.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
@endsection


@section('header')
<!-- Header -->
<header>
    <div class="max-w-7xl mx-auto px-4 py-1 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="page-tite">
            <h1 class="text-xl font-semibold text-gray-900">Task Management</h1>
            <p class="text-gray-500">Asign and Manage Tasks</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.tasks.create') }}">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm flex items-center">
                    <i class="bi bi-plus mr-1"></i> Create new Task
                </button>
            </a>
        </div>

    </div>
</header>
@endSection

@section('content')

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <!-- Task Filters -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6 hidden">
        <form action="{{ route('admin.tasks.index') }}" id="filter-form" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="task-status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="task-status" name="status"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                    <option value="*">All Tasks</option>
                    <option value="pendig">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="overdue">Overdue</option>
                </select>
            </div>
            <div>
                <label for="task-priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                <select id="task-priority" name="priority"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                    <option value="*">All Priorities</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
            </div>
            <div>
                <label for="task-category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select id="task-category" name="category"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                    <option value="*">All Members</option>
                    <option value="volunteers">All Officers/Volunteer</option>
                    <option value="buklod">Buklod</option>
                    <option value="kadiwa">kadiwa</option>
                    <option value="binhi">Binhi</option>
                    @forelse ($roleNames as $roleName)
                        <option value="{{  $roleName }}">{{  $roleName }}</option>
                    @empty
                        <option value="">No more...</option>
                    @endforelse
                </select>
            </div>
        </form>
    </div>

    <!-- Task Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Distributed Task</p>
                    <h3 class="text-2xl font-bold">{{ $distributedTaskCount }}</h3>

                    <p class="text-gray-500 text-sm mt-2"> Tasks Created</p>
                    <h3 class="text-sm text-gray-500 font-semibold">{{ $totalTaskCount }}</h3>

                </div>
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-full">
                    <i class="bi bi-list-task text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Pending</p>
                    <h3 class="text-2xl font-bold">{{ $pendingTaskCount }}</h3>
                </div>
                <div class="bg-green-100 text-green-800 p-3 rounded-full">
                    <i class="bi bi-check-circle text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">In Progress</p>
                    <h3 class="text-2xl font-bold">{{ $inProgressTaskCount }}</h3>
                </div>
                <div class="bg-yellow-100 text-yellow-800 p-3 rounded-full">
                    <i class="bi bi-arrow-repeat text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Completed</p>
                    <h3 class="text-2xl font-bold">{{ $completedTaskCount }}</h3>
                </div>
                <div class="bg-green-100 text-green-800 p-3 rounded-full">
                    <i class="bi bi-check-circle text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Overdue</p>
                    <h3 class="text-2xl font-bold">{{ $overdueTaskCount }}</h3>
                </div>
                <div class="bg-red-100 text-red-800 p-3 rounded-full">
                    <i class="bi bi-exclamation-triangle text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Task List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold">Tasks</h2>
            <div class="flex items-center space-x-2">
                <button class="text-gray-500 hover:text-primary">
                    <i class="bi bi-list-ul"></i>
                </button>
                <button class="text-gray-500 hover:text-primary">
                    <i class="bi bi-grid"></i>
                </button>
            </div>
        </div>

        <div class="task-list">
            @include('admin.tasks.task-list')
        </div>

    </div>
    @vite("resources/js/admin-tasks-index.js")
</main>
@endSection