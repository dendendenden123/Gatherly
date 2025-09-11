<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Occurrence
                </th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Checked In
                </th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($attendances as $attendance)
                <tr>
                    <td class="px-4 py-2 text-sm text-gray-700">
                        {{ optional($attendance->user)->full_name ?? 'N/A' }}
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-700">
                        {{ optional(optional($attendance->event_occurrence)->event)->event_name ?? 'N/A' }}
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-700">
                        #{{ $attendance->event_occurrence_id }}
                    </td>
                    <td class="px-4 py-2 text-sm">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-700">
                        {{ $attendance->formatted_check_in_time }}
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-500">
                        {{ $attendance->formatted_created_at }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">No attendance records.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>