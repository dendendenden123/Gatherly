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

                        <button class="action-btn edit-btn" onclick="editEvent({{ $event->id }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" class="delete-form" action="{{ route('admin.events.destroy') }}"
                            id="{{ $event->id }}">
                            @csrf
                            <input type="number" name="event_id" value="{{ $event->id }}" style="display: none;">
                            <button class="action-btn delete-btn" type="submit">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    @vite('resources/js/admin-events-index.js')
</table>