<!-- Task Table Header -->
<div
    class="hidden md:grid grid-cols-12 gap-4 p-4 border-b border-gray-200 bg-gray-50 text-sm font-medium text-gray-500">
    <div class="col-span-2">Title</div>
    <div class="col-span-2">Created By</div>
    <div class="col-span-2">Description</div>
    <div class="col-span-2">Priority</div>
    <div class="col-span-1">Created At</div>
</div>

<!-- Task Items -->
<div class="divide-y divide-gray-200">
    @forelse ($tasks as $task)
    <div class="p-4 hover:bg-gray-50 task-card transition priority-{{ $task?->priority }} cursor-pointer"
        onclick="window.location='{{ route('admin.tasks.show', $task->id) }}'">

        <div class="grid grid-cols-12 gap-4 items-center">

            <!-- Task Title and Assignee -->
            <div class="col-span-12 md:col-span-2">
                <h3 class="font-medium">{{ $task?->title }}</h3>
                <p class="text-sm text-gray-500">{{ $task?->assignee }}</p>
            </div>

            <!-- Task Creator -->
            <div class="col-span-6 md:col-span-2">
                <span>{{ $task?->user->first_name . ' ' . $task?->user->last_name }}</span>
            </div>

            <!-- Task Description -->
            <div class="col-span-6 md:col-span-2">
                <span>{{ $task?->description }}</span>
            </div>

            <!-- Task Priority -->
            <div class="col-span-6 md:col-span-2">
                <span class="px-2 py-1 text-xs rounded-full
                    @if($task?->priority == 'high') bg-red-100 text-red-800
                    @elseif($task?->priority == 'medium') bg-yellow-100 text-yellow-800
                    @else bg-blue-100 text-blue-800
                    @endif">
                    {{ ucfirst($task?->priority) }}
                </span>
            </div>

            <!-- Task Due Date -->
            <div class="col-span-6 md:col-span-2 text-sm hidden">
                <div class="flex items-center">
                    <i class="bi bi-calendar-week mr-2 text-gray-400"></i>
                    <span class="text-gray-700">{{ \Carbon\Carbon::parse($task?->due_date)->format('M d, Y') }}</span>
                </div>
                <div class="text-xs text-red-500 mt-1">
                    @php
                        $due = \Carbon\Carbon::parse($task?->due_date);
                        $now = now();
                        $diff = $now->diffInDays($due, false);
                    @endphp
                    @if ($diff === 1)
                        Tomorrow
                    @elseif ($diff === 0)
                        Today
                    @elseif ($diff > 1 && $diff <= 7)
                        {{ (int) $diff }} days left
                    @elseif ($diff > 7 && $diff <= 30)
                        {{ (int) ceil($diff / 7) }} week{{ ceil($diff / 7) > 1 ? 's' : '' }} left
                    @elseif ($diff > 30)
                        {{ (int) ceil($diff / 30) }} month{{ ceil($diff / 30) > 1 ? 's' : '' }} left
                    @elseif ($diff === -1)
                        Overdue by 1 day
                    @elseif ($diff < -1 && $diff >= -7)
                        Overdue by {{ (int) abs($diff) }} days
                    @elseif ($diff < -7 && $diff >= -30)
                        Overdue by {{ (int) ceil(abs($diff) / 7) }} week{{ ceil(abs($diff) / 7) > 1 ? 's' : '' }}
                    @elseif ($diff < -30)
                        Overdue by {{ (int) ceil(abs($diff) / 30) }} month{{ ceil(abs($diff) / 30) > 1 ? 's' : '' }}
                    @endif
                </div>
            </div>

            <!-- Created At -->
            <div class="col-span-6 md:col-span-1">
                <span>{{ $task?->created_at->format('M d, Y') }}</span>
            </div>

            <!-- Update Task Button (visible to all members) -->


            <!-- Action Edit and Delete (Admin Only) -->
            <div class="col-span-12 md:col-span-1 flex flex-col gap-2" onclick="event.stopPropagation();">
                @admin
                <a href="{{ route('admin.tasks.edit', $task->id) }}">
                    <button
                        class="action-btn edit-btn text-primary border border-primary px-2 py-1 rounded">Edit</button>
                </a>

                <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="action-btn delete-btn text-accent border border-accent px-2 py-1 rounded"
                        onclick="submitDeleteBtnConfirmation(event)">
                        Delete
                    </button>
                </form>
                @endadmin
            </div>

        </div>
    </div>
    @empty
    <div class="p-4 hover:bg-gray-50 task-card transition priority-high">
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-12 md:col-span-5">
                <h3 class="font-medium">No more tasks</h3>
            </div>
        </div>
    </div>
    @endforelse
</div>

@php
    $containerClass = "task-list";
@endphp
<x-pagination :containerClass="$containerClass" :data="$tasks" />

<!-- Session Alerts -->
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
        });
    </script>
@elseif(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Failed!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d63030',
        });
    </script>
@endif

<!-- Update Task Modal -->
<div id="updateTaskModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4" id="modal-title">Update Task Status</h3>
            <form id="updateTaskForm" method="POST" action="{{ route('member.task.updateStatus', $task->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="task_status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="task_status" name="status"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="task_comment" class="block text-sm font-medium text-gray-700 mb-2">Comment</label>
                    <textarea id="task_comment" name="comment" rows="4"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary focus:border-primary"
                        placeholder="Add your comment here..."></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="closeModal"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Open modal function
    function openUpdateModal(button) {
        const modal = document.getElementById('updateTaskModal');
        const form = document.getElementById('updateTaskForm');

        form.action = '/tasks/' + button.dataset.taskId;
        document.getElementById('task_status').value = button.dataset.taskStatus;
        document.getElementById('task_comment').value = button.dataset.taskComment;

        modal.classList.remove('hidden');
    }

    // Close modal
    document.getElementById('closeModal').addEventListener('click', function () {
        document.getElementById('updateTaskModal').classList.add('hidden');
    });
</script>