<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-800">Recent Attendance</h3>
        <div class="relative">
            <select
                class="appearance-none bg-light-gray border-0 text-gray-700 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-green">
                <option>Last 30 days</option>
                <option>Last 3 months</option>
                <option>Last 6 months</option>
                <option>Last year</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <i class="fas fa-chevron-down text-xs"></i>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Service</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Checked In</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Notes/ Reason</th>
                </tr>
            </thead>
            <tbody class=" bg-white divide-y divide-gray-200">
                @foreach ($attendances as $record)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $record->created_at->format('F j, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $record->event_occurrence->event->event_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php if ($record->status == "present") {
                        $class = "px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100
                        text-green-800";
                        } else {
                        $class = "px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100
                        text-red-800";
                        }
                        @endphp
                        <span class='{{ $class  }}'>
                            {{$record->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$record->check_in_time }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{$record->notes ? $record->notes : "-"}}
                    </td>
                </tr>
                @endForeach
            </tbody>
        </table>
        @php
            $containerClass = "show-attendance-list";
        @endphp
        <x-pagination :containerClass="$containerClass" :data="$attendances" />
    </div>
</div>