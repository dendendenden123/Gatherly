<h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Check-Ins</h3>
<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Event</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Time</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($attendance as $record)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full"
                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=40&h=40&q=80"
                                        alt="">
                                </div>
                                <div class="ml-4">
                                    <div id="" class="text-sm font-medium text-gray-900">{{ $record->user->first_name }}
                                        {{ $record->user->middle_name }} {{ $record->user->last_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{  $record->formatted_created_at}}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $record->event_occurrence->event->event_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->formatted_check_in_time }}
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $record->status == 'present' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $record->status }}
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @php
        $containerClass = "check-in-recent-attendance-list";
    @endphp
    <x-pagination :containerClass="$containerClass" :data="$attendance" />
</div>