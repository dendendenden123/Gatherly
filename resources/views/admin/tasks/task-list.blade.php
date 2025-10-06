<!-- Task Table Header -->
<div
    class="hidden md:grid grid-cols-12 gap-4 p-4 border-b border-gray-200 bg-gray-50 text-sm font-medium text-gray-500">
    <div class="col-span-2">Title</div>
    <div class="col-span-2">Created By</div>
    <div class="col-span-2">Description</div>
    <div class="col-span-2">Priority</div>
    <div class="col-span-2">Due Date</div>
    <div class="col-span-1">Created_at</div>
    @admin
    <div class="col-span-1">Action</div>
    @endadmin
</div>

<!-- Task Items -->
<div class="divide-y divide-gray-200">
    @forelse ($tasks as $task)
    <div class="p-4 hover:bg-gray-50 task-card transition priority-{{ $task?->priority }}"
        onclick="window.location.href='{{ route('admin.tasks.show', $task->id) }}'">

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
                <span class=`px-2 py-1 text-xs rounded-full @if($task?->priority == 'high') bg-red-100 text-red-800
                @elseif($task?->priority == 'medium') bg-yellow-100 text-yellow-800 @else bg-blue-100 text-blue-800
                    @endif `>{{ ucfirst($task?->priority) }}</span>
            </div>


            <!-- Task Due date -->
            <div class="col-span-6 md:col-span-2 text-sm">
                <div class="flex items-center">
                    <i class="bi bi-calendar-week mr-2 text-gray-400"></i>
                    <span class="text-gray-700">{{ \Carbon\Carbon::parse($task?->due_date)->format('M d, Y') }}</span>
                </div>
                <div class="text-xs text-red-500 mt-1">
                    @php
                        $due = $task?->due_date;
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
                        {{(int) ceil($diff / 7) }} week{{ ceil($diff / 7) > 1 ? 's' : '' }} left
                    @elseif ($diff > 30)
                        {{ (int) ceil($diff / 30) }} month{{ ceil($diff / 30) > 1 ? 's' : '' }} left
                    @elseif ($diff === -1)
                        Overdue by 1 day
                    @elseif ($diff < -1 && $diff >= -7)
                        Overdue by {{(int) abs($diff) }} days
                    @elseif ($diff < -7 && $diff >= -30)
                        Overdue by {{(int) ceil(abs($diff) / 7) }} week{{ ceil(abs($diff) / 7) > 1 ? 's' : '' }}
                    @elseif ($diff < -30)
                        Overdue by {{(int) ceil(abs($diff) / 30) }} month{{ ceil(abs($diff) / 30) > 1 ? 's' : '' }}
                    @endif
                </div>
            </div>


            <!-- Created_at -->
            <div class="col-span-6 md:col-span-1">
                <span>{{ $task?->created_at->format('M d, Y') }}</span>
            </div>

            <!-- Action Edit and Delete -->
            @admin
            <div class="col-span-12 md:col-span-1">
                <a href="{{ route('admin.tasks.edit', $task->id) }}"> <button
                        class="action-btn edit-btn text-primary border border-primary px-2 py-1 rounded">Edit</button>
                </a>

                <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: '{{ session('success') }}',
                                confirmButtonColor: '#3085d6',
                            })
                        </script>
                    @elseif(session('error'))
                        <script>
                            Swal.fire({
                                icon: 'Failed',
                                title: 'Failed!',
                                text: '{{ session('error') }}',
                                confirmButtonColor: '#d63030ff',
                            })
                        </script>
                    @endif
                    <button type="submit" id="delete_{{ $task->id }}"
                        class="action-btn delete-btn text-accent border border-accent px-2 py-1 rounded"
                        onclick="()=>submitDeleteBtnConfirmation(e)">
                        Delete
                    </button>
                </form>
            </div>
            @endadmin
        </div>
    </div>
    @empty
    <div class="p-4 hover:bg-gray-50 task-card transition priority-high">
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-12 md:col-span-5">
                <h3 class="font-medium">No more task</h3>
            </div>

        </div>
    </div>
    @endforelse
</div>

@php
    $containerClass = "task-list"
@endphp
<x-pagination :containerClass="$containerClass" :data="$tasks" />