<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-sm uppercase tracking-wider">
                Member</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Role</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Event</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status</th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach($filteredAttendancesPaginated as $record)

        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div
                        class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify- #2ecc71 #2ecc71center">
                        <i class="bi bi-person text-gray-500"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ $record->user->first_name }}
                            {{$record->user->last_name }}
                        </div>
                        <div class="text-sm text-gray-500">{{ $record->user->email }}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{$record->user->role}}</div>
                <div class="text-sm text-gray-500">
                    @php
                        $age = $record->user->birthdate->age;
                        if ($age < 18) {
                            $ageGroup = "Binhi Youth";
                        } else if ($age >= 18 && $record->user->marital_status != "married") {
                            $ageGroup = "Kadiwa Youth";
                        } else if ($age >= 18 && $record->user->marital_status == "married") {
                            $ageGroup = "Buklod/Married";
                        }
                    @endphp
                    {{  $ageGroup  }}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">
                    {{  $record->updated_at->format('M d, Y') ? $record->updated_at->format('M d, Y') : 'No record'}}
                </div>
                <div class="text-sm text-gray-500">
                    {{ $record->event_occurrence->event->event_name ? $record->event_occurrence->event->event_name : 'No record'}}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">

                @if (is_Null($record) || is_Null($record->status) || $record->status === 'absent')
                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Absent</span>
                @elseif ($record->status === 'present')
                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Present</span>
                @else
                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Unknown</span>
                @endif

            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="{{ route('admin.attendance.show', $record->user_id) }}">
                    <button class="text-gray-500 hover:text-gray-700">History</button>
                </a>
            </td>
        </tr>
        @endForeach

    </tbody>
</table>
@php
    $containerClass = "index-attendance-list";
@endphp
<x-pagination :containerClass="$containerClass" :data="$filteredAttendancesPaginated" />