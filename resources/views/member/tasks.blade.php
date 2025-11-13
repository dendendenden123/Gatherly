@extends('layouts.member')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/member/tasks.css') }}">
@endsection

@section('header')
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Tasks</h1>
            <p class="text-sm text-gray-500">Manage your church responsibilities</p>
        </div>
    </div>
</header>
@endSection


@section('content')
<main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <!-- Task Filters -->
    <!-- Task Filters -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form action="{{ route('member.task') }}" id="filter-form" class="grid grid-cols-1 md:grid-cols-3 gap-3">
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
        </form>
    </div>

    <!-- Task Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Tasks</p>
                    <h3 class="text-2xl font-bold">{{ $totalTaskCount }}</h3>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-full">
                    <i class="bi bi-list-task text-xl"></i>
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
            <h2 class="text-lg font-semibold">My Tasks</h2>
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
</main>
</div>

@vite("resources/js/admin-tasks-index.js")
@endSection