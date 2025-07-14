<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Member</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Role</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Last Attended</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Last month attendance %</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status</th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach($users as $user)
        @php
            $lastAttendance = $user->attendances->last();
        @endphp
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div
                        class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify- #2ecc71 #2ecc71center">
                        <i class="bi bi-person text-gray-500"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ $user->first_name }}
                            {{ $user->last_name }}
                        </div>
                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{$user->role}}</div>
                <div class="text-sm text-gray-500">
                    @php
                        $age = \Carbon\Carbon::parse($user->birthdate)->age;
                        if ($age < 18) {
                            $ageGroup = "Binhi Youth";
                        } else if ($age >= 18 && $user->marital_status != "married") {
                            $ageGroup = "Kadiwa Youth";
                        } else if ($age >= 18 && $user->marital_status == "married") {
                            $ageGroup = "Buklod/Married";
                        }
                    @endphp
                    {{  $ageGroup  }}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">
                    {{  $lastAttendance ? $lastAttendance->created_at->format('M d, Y') : 'No record'}}
                </div>
                <div class="text-sm text-gray-500">
                    {{ $lastAttendance ? $lastAttendance->event_occurrence->event->event_name : 'No record'}}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="w-16 mr-2">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full" style="width: {{ $user->getAttendanceRate() }}%">
                            </div>
                        </div>
                    </div>
                    <div class="text-sm">{{ $user->getAttendanceRate() }}%</div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">

                @if($user->status == 'partially-active')
                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Partially
                        Active</span>
                @elseif($user->status == 'expelled')
                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Expelled</span>
                @elseif($user->status == 'active')
                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                @elseif($user->status == 'inactive')
                    <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">Inactive</span>
                @else
                    <span class="px-2 py-1 text-xs rounded-full bg-grey-100 text-grey-800">No Record</span>
                @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="{{ route('admin.attendance.show', $user->id) }}">
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
<x-pagination :containerClass="$containerClass" :data="$users" />