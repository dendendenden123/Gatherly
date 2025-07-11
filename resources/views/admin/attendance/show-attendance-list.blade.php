@foreach ($user->attendances as $record)
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