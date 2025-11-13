@extends('layouts.admin')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .status-in_progress {
            background-color: #DBEAFE;
            color: #1E40AF;
        }

        .status-completed {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-overdue {
            background-color: #FEE2E2;
            color: #991B1B;
        }

        .priority-high {
            background-color: #FEE2E2;
            color: #991B1B;
        }

        .priority-medium {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .priority-low {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
    </style>
@endsection

@section('header')
    <!-- Header -->
    <header>
        <div class="max-w-7xl mx-auto px-4 py-1 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="page-title">
                <h1 class="text-xl font-semibold text-gray-900">Task Details</h1>
                <p class="text-gray-500">View task information and assigned users status</p>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.tasks.edit', $task->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                    <i class="bi bi-pencil mr-2"></i> Edit Task
                </a>
                <a href="{{ route('admin.tasks.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="bi bi-arrow-left mr-2"></i> Back to Tasks
                </a>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Task Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8" id="summary-cards">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-gray-500 font-medium text-sm">Total Assigned</div>
                    <i class="bi bi-people text-blue-500"></i>
                </div>
                <div class="text-2xl font-semibold text-gray-800" id="total-count">{{ $totalAssigned }}</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-gray-500 font-medium text-sm">Pending</div>
                    <i class="bi bi-clock text-yellow-500"></i>
                </div>
                <div class="text-2xl font-semibold text-gray-800" id="pending-count">{{ $pendingCount }}</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-gray-500 font-medium text-sm">In Progress</div>
                    <i class="bi bi-arrow-repeat text-blue-500"></i>
                </div>
                <div class="text-2xl font-semibold text-gray-800" id="inprogress-count">{{ $inProgressCount }}</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-gray-500 font-medium text-sm">Completed</div>
                    <i class="bi bi-check-circle text-green-500"></i>
                </div>
                <div class="text-2xl font-semibold text-gray-800" id="completed-count">{{ $completedCount }}</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-gray-500 font-medium text-sm">Overdue</div>
                    <i class="bi bi-exclamation-triangle text-red-500"></i>
                </div>
                <div class="text-2xl font-semibold text-gray-800" id="overdue-count">{{ $overdueCount }}</div>
            </div>
        </div>

        <!-- Task Details -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Task Information</h2>
            </div>

            <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Task Title</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $task->title }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Description</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $task->description ?? 'No description provided' }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Assigned To</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($task->assignee) }}</p>
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Created By</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $task->user->first_name . ' ' . $task->user->last_name }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Priority</h3>
                        <span class="status-badge priority-{{ $task->priority }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Due Date</h3>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($task->due_date)->format('M j, Y') }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Created At</h3>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $task->created_at->format('M j, Y g:i A') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assigned Users Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Assigned Users</h2>
            </div>

            <!-- Filters -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <form id="filter-form" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    <div>
                        <label for="filter-status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="filter-status" name="status"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary text-sm">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="overdue">Overdue</option>
                        </select>
                    </div>
                    <div>
                        <label for="filter-start-date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" id="filter-start-date" name="start_date"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary text-sm">
                    </div>
                    <div>
                        <label for="filter-end-date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" id="filter-end-date" name="end_date"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary text-sm">
                    </div>
                    <div>
                        <label for="filter-user-name" class="block text-sm font-medium text-gray-700 mb-1">User Name</label>
                        <input type="text" id="filter-user-name" name="user_name" placeholder="Search by name..."
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary text-sm">
                    </div>
                    <div>
                        <button type="button" onclick="resetFilters()" 
                            class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition">
                            <i class="bi bi-arrow-clockwise mr-1"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto" id="users-table-container">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Comment
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Last Updated
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($assignedUsers as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ $user->profile_image && !str_contains($user->profile_image, 'Default_pfp.jpg') ? asset('storage/' . $user->profile_image) : $user->profile_image }}"
                                                alt="{{ $user->first_name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $user->first_name . ' ' . $user->last_name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="status-badge status-{{ $user->pivot->status }}">
                                        {{ ucfirst(str_replace('_', ' ', $user->pivot->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $user->pivot->comment }}">
                                        {{ $user->pivot->comment ?? 'No comment' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($user->pivot->updated_at)->format('M j, Y g:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No users assigned to this task yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filter-form');
            const filterStatus = document.getElementById('filter-status');
            const filterStartDate = document.getElementById('filter-start-date');
            const filterEndDate = document.getElementById('filter-end-date');
            const filterUserName = document.getElementById('filter-user-name');
            const usersTableContainer = document.getElementById('users-table-container');

            // Store original counts
            const originalCounts = {
                total: {{ $totalAssigned }},
                pending: {{ $pendingCount }},
                inProgress: {{ $inProgressCount }},
                completed: {{ $completedCount }},
                overdue: {{ $overdueCount }}
            };

            // Function to update summary cards
            function updateSummaryCards(counts) {
                document.getElementById('total-count').textContent = counts.total;
                document.getElementById('pending-count').textContent = counts.pending;
                document.getElementById('inprogress-count').textContent = counts.inProgress;
                document.getElementById('completed-count').textContent = counts.completed;
                document.getElementById('overdue-count').textContent = counts.overdue;
            }

            // Function to filter users
            function filterUsers() {
                const status = filterStatus.value.toLowerCase();
                const startDate = filterStartDate.value;
                const endDate = filterEndDate.value;
                const userName = filterUserName.value.toLowerCase();

                // Get all table rows
                const rows = usersTableContainer.querySelectorAll('tbody tr');
                let visibleCount = 0;
                
                // Counters for summary cards
                const counts = {
                    total: 0,
                    pending: 0,
                    inProgress: 0,
                    completed: 0,
                    overdue: 0
                };

                rows.forEach(row => {
                    // Skip empty state row
                    if (row.querySelector('td[colspan]')) {
                        row.style.display = 'none';
                        return;
                    }

                    let show = true;

                    // Get row status for counting
                    const statusBadge = row.querySelector('.status-badge');
                    let rowStatus = '';
                    if (statusBadge) {
                        rowStatus = statusBadge.classList.toString().match(/status-(\w+)/)?.[1] || '';
                    }

                    // Filter by status
                    if (status) {
                        if (rowStatus !== status) {
                            show = false;
                        }
                    }

                    // Filter by user name
                    if (userName && show) {
                        const userNameCell = row.querySelector('td:first-child .text-sm');
                        if (userNameCell) {
                            const rowUserName = userNameCell.textContent.trim().toLowerCase();
                            if (!rowUserName.includes(userName)) {
                                show = false;
                            }
                        }
                    }

                    // Filter by date range
                    if ((startDate || endDate) && show) {
                        const lastUpdatedCell = row.querySelector('td:last-child');
                        if (lastUpdatedCell) {
                            const dateText = lastUpdatedCell.textContent.trim();
                            // Parse date from format "Jan 1, 2025 12:00 AM"
                            const rowDate = new Date(dateText);
                            
                            if (startDate) {
                                const start = new Date(startDate);
                                start.setHours(0, 0, 0, 0);
                                if (rowDate < start) {
                                    show = false;
                                }
                            }

                            if (endDate && show) {
                                const end = new Date(endDate);
                                end.setHours(23, 59, 59, 999);
                                if (rowDate > end) {
                                    show = false;
                                }
                            }
                        }
                    }

                    row.style.display = show ? '' : 'none';
                    
                    if (show) {
                        visibleCount++;
                        counts.total++;
                        
                        // Count by status
                        switch(rowStatus) {
                            case 'pending':
                                counts.pending++;
                                break;
                            case 'in_progress':
                                counts.inProgress++;
                                break;
                            case 'completed':
                                counts.completed++;
                                break;
                            case 'overdue':
                                counts.overdue++;
                                break;
                        }
                    }
                });

                // Update summary cards
                updateSummaryCards(counts);

                // Show "no results" message if all rows are hidden
                const tbody = usersTableContainer.querySelector('tbody');
                
                // Remove existing no results message
                const existingNoResults = tbody.querySelector('.no-results-row');
                if (existingNoResults) {
                    existingNoResults.remove();
                }

                if (visibleCount === 0) {
                    const noResultsRow = document.createElement('tr');
                    noResultsRow.className = 'no-results-row';
                    noResultsRow.innerHTML = '<td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No users found matching the filters.</td>';
                    tbody.appendChild(noResultsRow);
                }
            }

            // Add event listeners
            filterStatus.addEventListener('change', filterUsers);
            filterStartDate.addEventListener('change', filterUsers);
            filterEndDate.addEventListener('change', filterUsers);
            filterUserName.addEventListener('input', filterUsers);

            // Reset filters function
            window.resetFilters = function() {
                filterStatus.value = '';
                filterStartDate.value = '';
                filterEndDate.value = '';
                filterUserName.value = '';
                
                // Show all rows
                const rows = usersTableContainer.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    if (!row.classList.contains('no-results-row')) {
                        row.style.display = '';
                    }
                });
                
                // Remove no results message
                const tbody = usersTableContainer.querySelector('tbody');
                const existingNoResults = tbody.querySelector('.no-results-row');
                if (existingNoResults) {
                    existingNoResults.remove();
                }
                
                // Restore original counts
                updateSummaryCards(originalCounts);
            };
        });
    </script>
@endsection