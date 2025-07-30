<table class="events-table">
    <thead>
        <tr>
            <th>Event Name</th>
            <th>Type</th>
            <th>Date & Time</th>
            <th>Location</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($events as $event)
            <tr id="event-{{ $event->id }}">
                <td>
                    <div class="event-name">{{ $event->event_name }}</div>
                    <div class="event-description">{{ Str::limit($event->event_description, 50) }}</div>
                </td>
                <td>
                    <span class="event-type">{{ $event->event_type }}</span>
                </td>
                <td>
                    <div class="event-datetime">
                        <span class="event-date">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</span>
                        <span class="event-time">{{ $event->start_time }} - {{ $event->end_time }}</span>
                    </div>
                </td>
                <td>{{ $event->location }}</td>
                <td>
                    @php
                        $statusClass = '';
                        if ($event->status === 'upcoming')
                            $statusClass = 'status-upcoming';
                        elseif ($event->status === 'ongoing')
                            $statusClass = 'status-ongoing';
                        elseif ($event->status === 'completed')
                            $statusClass = 'status-completed';
                        else
                            $statusClass = 'status-cancelled';
                    @endphp
                    <span class="event-status {{ $statusClass }}">{{ ucfirst($event->status) }}</span>
                </td>
                <td>
                    <div class="actions">
                        <button class="action-btn edit-btn" data-url="{{ route('admin.events.edit', $event->id) }}">
                            <i class="fas fa-edit"></i>
                        </button>

                        <form method="POST" class="form-deletion" action="{{ route('admin.events.destroy', $event->id) }}"
                            data-form-id={{ $event->id  }}>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </div>
                </td>
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: '{{ session('success') }}',
                            confirmButtonColor: '#3085d6',
                        });
                    </script>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
@php
    $containerClass = "index-events-list";
@endphp
<x-pagination :containerClass="$containerClass" :data="$events" />