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
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="task-status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="task-status"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                    <option>All Tasks</option>
                    <option>Not Started</option>
                    <option>In Progress</option>
                    <option>Completed</option>
                </select>
            </div>
            <div>
                <label for="task-priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                <select id="task-priority"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                    <option>All Priorities</option>
                    <option>High</option>
                    <option>Medium</option>
                    <option>Low</option>
                </select>
            </div>
            <div>
                <label for="task-category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select id="task-category"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                    <option>All Categories</option>
                    <option>Worship</option>
                    <option>Outreach</option>
                    <option>Children</option>
                    <option>Administration</option>
                    <option>Facilities</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md w-full">
                    Apply Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Task Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Tasks</p>
                    <h3 class="text-2xl font-bold">14</h3>
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
                    <h3 class="text-2xl font-bold">5</h3>
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
                    <h3 class="text-2xl font-bold">6</h3>
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
                    <h3 class="text-2xl font-bold">3</h3>
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

        <!-- Task Table Header -->
        <div
            class="hidden md:grid grid-cols-12 gap-4 p-4 border-b border-gray-200 bg-gray-50 text-sm font-medium text-gray-500">
            <div class="col-span-1"></div>
            <div class="col-span-5">Task</div>
            <div class="col-span-2">Due Date</div>
            <div class="col-span-2">Priority</div>
            <div class="col-span-2">Progress</div>
        </div>

        <!-- Task Items -->
        <div class="divide-y divide-gray-200">
            <!-- Task 1 (High Priority) -->
            <div class="p-4 hover:bg-gray-50 task-card transition priority-high">
                <div class="grid grid-cols-12 gap-4 items-center">
                    <div class="col-span-1 flex justify-center">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="checkbox hidden">
                            <span class="checkmark w-5 h-5 border border-gray-300 rounded inline-block relative"></span>
                        </label>
                    </div>
                    <div class="col-span-12 md:col-span-5">
                        <h3 class="font-medium">Prepare slides for Sunday sermon</h3>
                        <p class="text-sm text-gray-500">Worship Team</p>
                    </div>
                    <div class="col-span-6 md:col-span-2 text-sm">
                        <div class="flex items-center">
                            <i class="bi bi-calendar-week mr-2 text-gray-400"></i>
                            <span class="text-gray-700">Jun 15, 2023</span>
                        </div>
                        <div class="text-xs text-red-500 mt-1">Due tomorrow</div>
                    </div>
                    <div class="col-span-6 md:col-span-2">
                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">High</span>
                    </div>
                    <div class="col-span-12 md:col-span-2">
                        <div class="w-full bg-gray-200 progress-bar">
                            <div class="bg-primary h-full progress-bar" style="width: 30%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">30% complete</div>
                    </div>
                </div>
            </div>

            <!-- Task 2 (Medium Priority) -->
            <div class="p-4 hover:bg-gray-50 task-card transition priority-medium">
                <div class="grid grid-cols-12 gap-4 items-center">
                    <div class="col-span-1 flex justify-center">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="checkbox hidden">
                            <span class="checkmark w-5 h-5 border border-gray-300 rounded inline-block relative"></span>
                        </label>
                    </div>
                    <div class="col-span-12 md:col-span-5">
                        <h3 class="font-medium">Organize volunteers for VBS</h3>
                        <p class="text-sm text-gray-500">Children's Ministry</p>
                    </div>
                    <div class="col-span-6 md:col-span-2 text-sm">
                        <div class="flex items-center">
                            <i class="bi bi-calendar-week mr-2 text-gray-400"></i>
                            <span class="text-gray-700">Jun 18, 2023</span>
                        </div>
                        <div class="text-xs text-yellow-600 mt-1">Due in 3 days</div>
                    </div>
                    <div class="col-span-6 md:col-span-2">
                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Medium</span>
                    </div>
                    <div class="col-span-12 md:col-span-2">
                        <div class="w-full bg-gray-200 progress-bar">
                            <div class="bg-primary h-full progress-bar" style="width: 65%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">65% complete</div>
                    </div>
                </div>
            </div>

            <!-- Task 3 (Completed) -->
            <div class="p-4 hover:bg-gray-50 task-card transition bg-green-50">
                <div class="grid grid-cols-12 gap-4 items-center">
                    <div class="col-span-1 flex justify-center">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="checkbox hidden" checked>
                            <span class="checkmark w-5 h-5 border border-gray-300 rounded inline-block relative"></span>
                        </label>
                    </div>
                    <div class="col-span-12 md:col-span-5">
                        <h3 class="font-medium line-through">Purchase supplies for food pantry</h3>
                        <p class="text-sm text-gray-500">Outreach Ministry</p>
                    </div>
                    <div class="col-span-6 md:col-span-2 text-sm">
                        <div class="flex items-center">
                            <i class="bi bi-calendar-week mr-2 text-gray-400"></i>
                            <span class="text-gray-700">Jun 10, 2023</span>
                        </div>
                        <div class="text-xs text-green-600 mt-1">Completed</div>
                    </div>
                    <div class="col-span-6 md:col-span-2">
                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Low</span>
                    </div>
                    <div class="col-span-12 md:col-span-2">
                        <div class="w-full bg-gray-200 progress-bar">
                            <div class="bg-primary h-full progress-bar" style="width: 100%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">100% complete</div>
                    </div>
                </div>
            </div>

            <!-- Task 4 (Overdue) -->
            <div class="p-4 hover:bg-gray-50 task-card transition priority-high">
                <div class="grid grid-cols-12 gap-4 items-center">
                    <div class="col-span-1 flex justify-center">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="checkbox hidden">
                            <span class="checkmark w-5 h-5 border border-gray-300 rounded inline-block relative"></span>
                        </label>
                    </div>
                    <div class="col-span-12 md:col-span-5">
                        <h3 class="font-medium">Submit prayer team schedule</h3>
                        <p class="text-sm text-gray-500">Prayer Ministry</p>
                    </div>
                    <div class="col-span-6 md:col-span-2 text-sm">
                        <div class="flex items-center">
                            <i class="bi bi-calendar-week mr-2 text-gray-400"></i>
                            <span class="text-gray-700">Jun 5, 2023</span>
                        </div>
                        <div class="text-xs text-red-500 mt-1">Overdue by 8 days</div>
                    </div>
                    <div class="col-span-6 md:col-span-2">
                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">High</span>
                    </div>
                    <div class="col-span-12 md:col-span-2">
                        <div class="w-full bg-gray-200 progress-bar">
                            <div class="bg-primary h-full progress-bar" style="width: 10%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">10% complete</div>
                    </div>
                </div>
            </div>

            <!-- Task 5 (Low Priority) -->
            <div class="p-4 hover:bg-gray-50 task-card transition priority-low">
                <div class="grid grid-cols-12 gap-4 items-center">
                    <div class="col-span-1 flex justify-center">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="checkbox hidden">
                            <span class="checkmark w-5 h-5 border border-gray-300 rounded inline-block relative"></span>
                        </label>
                    </div>
                    <div class="col-span-12 md:col-span-5">
                        <h3 class="font-medium">Update member contact list</h3>
                        <p class="text-sm text-gray-500">Administration</p>
                    </div>
                    <div class="col-span-6 md:col-span-2 text-sm">
                        <div class="flex items-center">
                            <i class="bi bi-calendar-week mr-2 text-gray-400"></i>
                            <span class="text-gray-700">Jun 25, 2023</span>
                        </div>
                        <div class="text-xs text-blue-500 mt-1">Due in 10 days</div>
                    </div>
                    <div class="col-span-6 md:col-span-2">
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Low</span>
                    </div>
                    <div class="col-span-12 md:col-span-2">
                        <div class="w-full bg-gray-200 progress-bar">
                            <div class="bg-primary h-full progress-bar" style="width: 0%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">Not started</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span
                    class="font-medium">14</span> tasks
            </div>
            <div class="flex space-x-2">
                <button
                    class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </button>
                <button
                    class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </button>
            </div>
        </div>
    </div>
</main>
</div>

<!-- New Task Modal (Hidden by default) -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">New Task</h3>
            <button class="text-gray-500 hover:text-gray-700">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="p-4">
            <form>
                <div class="mb-4">
                    <label for="task-title" class="block text-sm font-medium text-gray-700 mb-1">Task Title</label>
                    <input type="text" id="task-title"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                </div>
                <div class="mb-4">
                    <label for="task-description"
                        class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="task-description" rows="3"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="task-due-date" class="block text-sm font-medium text-gray-700 mb-1">Due
                            Date</label>
                        <input type="date" id="task-due-date"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="task-priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                        <select id="task-priority"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                            <option>Low</option>
                            <option>Medium</option>
                            <option>High</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="task-category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select id="task-category"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                        <option>Select a category</option>
                        <option>Worship</option>
                        <option>Outreach</option>
                        <option>Children</option>
                        <option>Administration</option>
                        <option>Facilities</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="task-assigned" class="block text-sm font-medium text-gray-700 mb-1">Assigned
                        To</label>
                    <select id="task-assigned"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                        <option>Myself</option>
                        <option>Pastor John</option>
                        <option>Worship Team</option>
                        <option>Outreach Committee</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="p-4 border-t border-gray-200 flex justify-end space-x-3">
            <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50">
                Cancel
            </button>
            <button class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md">
                Create Task
            </button>
        </div>
    </div>
</div>
@endSection

<script>
    // Task completion toggle
    document.querySelectorAll('.checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const taskCard = this.closest('.task-card');
            if (this.checked) {
                taskCard.classList.add('bg-green-50');
                taskCard.querySelector('h3').classList.add('line-through');
                // Update progress to 100%
                const progressBar = taskCard.querySelector('.progress-bar:last-child');
                progressBar.style.width = '100%';
                taskCard.querySelector('.text-xs.text-gray-500').textContent = '100% complete';
                // Update status to completed
                const statusElement = taskCard.querySelector('.text-xs.mt-1');
                statusElement.textContent = 'Completed';
                statusElement.classList.remove('text-red-500', 'text-yellow-600', 'text-blue-500');
                statusElement.classList.add('text-green-600');
            } else {
                taskCard.classList.remove('bg-green-50');
                taskCard.querySelector('h3').classList.remove('line-through');
                // Here you would revert progress based on actual task status
            }
        });
    });

    // New task button functionality
    document.querySelector('header button').addEventListener('click', function () {
        document.querySelector('.fixed').classList.remove('hidden');
    });

    // Close modal
    document.querySelector('.fixed button').addEventListener('click', function () {
        document.querySelector('.fixed').classList.add('hidden');
    });
</script>