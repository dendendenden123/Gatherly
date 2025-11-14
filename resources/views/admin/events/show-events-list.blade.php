@forelse($eventOccurrences as $occurrence)
    <div class="px-6 py-4 hover:bg-gray-50 transition duration-150 ease-in-out">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex items-center mb-3 md:mb-0">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                    <i class="bi bi-calendar-event text-indigo-600"></i>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">
                        {{ \Carbon\Carbon::parse($occurrence->occurrence_date)->format('l, F j, Y') }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} -
                        {{ $event->end_time }}
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $occurrence->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($occurrence->status) }}
                </span>

                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium  {{ $occurrence->attendance_checked ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $occurrence->attendance_checked ? 'Attendance Checked' : 'Pending Check' }}
                </span>

                <div class="flex space-x-2">
                    <a class="text-blue-600 hover:text-blue-900">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="px-6 py-8 text-center">
        <i class="bi bi-calendar-x text-4xl text-gray-400 mb-3"></i>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No occurrences scheduled</h3>
        <p class="mt-1 text-sm text-gray-500">This event doesn't have any scheduled occurrences yet.</p>
    </div>
@endforelse

{{ $eventOccurrences->links() }}