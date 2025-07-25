@extends('layouts.admin')
@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #a5b4fc;
            --secondary: #f43f5e;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --success: #10b981;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem 2rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray);
        }

        .card-value {
            font-size: 2rem;
            font-weight: 600;
            color: var(--dark);
        }

        .card-footer {
            font-size: 0.75rem;
            color: var(--gray);
        }

        .events-container {
            padding: 0 2rem 2rem;
        }

        .events-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .events-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .search-filter {
            display: flex;
            gap: 1rem;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            width: 240px;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .filter-btn {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .events-table {
            width: 100%;
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .events-table th {
            background-color: #f8fafc;
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .events-table td {
            padding: 1rem 1.5rem;
            border-top: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .event-name {
            font-weight: 500;
            color: var(--dark);
        }

        .event-type {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 9999px;
            background-color: #e0e7ff;
            color: var(--primary);
        }

        .event-datetime {
            display: flex;
            flex-direction: column;
        }

        .event-date {
            font-weight: 500;
        }

        .event-time {
            font-size: 0.875rem;
            color: var(--gray);
        }

        .event-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-upcoming {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        .status-ongoing {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-completed {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .edit-btn {
            background-color: #e0f2fe;
            color: #0ea5e9;
        }

        .edit-btn:hover {
            background-color: #bae6fd;
        }

        .delete-btn {
            background-color: #fee2e2;
            color: #ef4444;
        }

        .delete-btn:hover {
            background-color: #fecaca;
        }

        .view-btn {
            background-color: #e0e7ff;
            color: #6366f1;
        }

        .view-btn:hover {
            background-color: #c7d2fe;
        }

        .add-event-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s;
        }

        .add-event-btn:hover {
            transform: scale(1.05);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 0.5rem;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
        }

        .btn-outline {
            background-color: white;
            color: var(--dark);
            border: 1px solid #e2e8f0;
        }

        /* Occurrences Section */
        .occurrences-container {
            margin-top: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .occurrences-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .occurrences-title {
            font-size: 1.125rem;
            font-weight: 600;
        }

        .occurrences-table {
            width: 100%;
        }

        .occurrences-table th {
            background-color: #f8fafc;
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .occurrences-table td {
            padding: 0.75rem 1rem;
            border-top: 1px solid #f1f5f9;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge i {
            font-size: 0.625rem;
        }
    </style>
@endsection

@section('header')
    <div class="header">
        <div class="header-title">
            <h1>Gatherly - Events Management</h1>
        </div>
        <div class="user-avatar"></div>
    </div>
@endsection

@section('content')
    <!-- Dashboard Cards -->
    <div class="dashboard-cards">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-title">Total Events</div>
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="card-value">{{ $totalEvents }}</div>
            <div class="card-footer">All events</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-title">Upcoming Events</div>
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="card-value">{{ $upcomingEvents }}</div>
            <div class="card-footer">Next 30 days</div>
        </div>

    </div>

    <!-- Events Table -->
    <div class="events-container">
        <div class="events-header">
            <h2 class="events-title">All Events</h2>
            <div class="search-filter">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search events..." id="searchInput">
                </div>
                <button class="filter-btn">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
            </div>
        </div>

        <table class="events-table">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Type</th>
                    <th>Date & Time</th>
                    <th>Location</th>
                    <th>Volunteers</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                    <tr data-event-id="{{ $event->id }}">
                        <td>
                            <div class="event-name">{{ $event->event_name }}</div>
                            <div class="event-description">{{ Str::limit($event->event_description, 50) }}</div>
                        </td>
                        <td>
                            <span class="event-type">{{ $event->event_type }}</span>
                        </td>
                        <td>
                            <div class="event-datetime">
                                <span
                                    class="event-date">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</span>
                                <span class="event-time">{{ $event->start_time }} - {{ $event->end_time }}</span>
                            </div>
                        </td>
                        <td>{{ $event->location }}</td>
                        <td>{{ $event->number_Volunteer_needed ?? 0 }}</td>
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
                                <button class="action-btn view-btn" onclick="viewEvent({{ $event->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn edit-btn" onclick="editEvent({{ $event->id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete-btn" onclick="deleteEvent({{ $event->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Occurrences Row (hidden by default) -->
                    <tr class="occurrences-row" id="occurrences-{{ $event->id }}" style="display: none;">
                        <td colspan="7">
                            <div class="occurrences-container">
                                <div class="occurrences-header">
                                    <h3 class="occurrences-title">Event Occurrences</h3>
                                    <button class="btn btn-outline" onclick="addOccurrence({{ $event->id }})">
                                        <i class="fas fa-plus"></i> Add Occurrence
                                    </button>
                                </div>
                                <table class="occurrences-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                            <th>Attendance</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($event->event_occurrences as $occurrence)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($occurrence->occurrence_date)->format('M d, Y') }}</td>
                                                <td>{{ $occurrence->start_time }} - {{ $occurrence->end_time }}</td>
                                                <td>
                                                    @php
                                                        $statusClass = '';
                                                        if ($occurrence->status === 'scheduled')
                                                            $statusClass = 'status-upcoming';
                                                        elseif ($occurrence->status === 'in_progress')
                                                            $statusClass = 'status-ongoing';
                                                        elseif ($occurrence->status === 'completed')
                                                            $statusClass = 'status-completed';
                                                        else
                                                            $statusClass = 'status-cancelled';
                                                    @endphp
                                                    <span
                                                        class="event-status {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $occurrence->status)) }}</span>
                                                </td>
                                                <td>
                                                    @if($occurrence->attendance_checked)
                                                        <span class="badge" style="background-color: #dcfce7; color: #166534;">
                                                            <i class="fas fa-check"></i> Recorded
                                                        </span>
                                                    @else
                                                        <span class="badge" style="background-color: #fee2e2; color: #991b1b;">
                                                            <i class="fas fa-times"></i> Pending
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="actions">
                                                        <button class="action-btn edit-btn"
                                                            onclick="editOccurrence({{ $occurrence->id }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="action-btn delete-btn"
                                                            onclick="deleteOccurrence({{ $occurrence->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Event Button -->
    <div class="add-event-btn" id="addEventBtn">
        <i class="fas fa-plus"></i>
    </div>

    <!-- Event Modal -->
    <div class="modal" id="eventModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Add New Event</h2>
                <button class="close-modal" id="closeModal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <input type="hidden" id="eventId">
                    <div class="form-group">
                        <label for="eventName">Event Name *</label>
                        <input type="text" id="eventName" required>
                    </div>
                    <div class="form-group">
                        <label for="eventDescription">Description</label>
                        <textarea id="eventDescription" rows="3"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="eventType">Event Type *</label>
                            <select id="eventType" required>
                                <option value="service">Worship Service</option>
                                <option value="meeting">Meeting</option>
                                <option value="class">Class/Study</option>
                                <option value="social">Social Event</option>
                                <option value="outreach">Outreach</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="eventStatus">Status *</label>
                            <select id="eventStatus" required>
                                <option value="upcoming">Upcoming</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="startDate">Start Date *</label>
                            <input type="date" id="startDate" required>
                        </div>
                        <div class="form-group">
                            <label for="startTime">Start Time *</label>
                            <input type="time" id="startTime" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="endDate">End Date</label>
                            <input type="date" id="endDate">
                        </div>
                        <div class="form-group">
                            <label for="endTime">End Time</label>
                            <input type="time" id="endTime">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location">
                    </div>
                    <div class="form-group">
                        <label for="volunteersNeeded">Volunteers Needed</label>
                        <input type="number" id="volunteersNeeded" min="0">
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="isRecurring"> Recurring Event
                        </label>
                        <div id="recurringOptions" style="display: none; margin-top: 10px;">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="repeatFrequency">Frequency</label>
                                    <select id="repeatFrequency">
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="repeatUntil">Repeat Until</label>
                                    <input type="date" id="repeatUntil">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" id="cancelBtn">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Occurrence Modal -->
    <div class="modal" id="occurrenceModal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h2 class="modal-title">Add Occurrence</h2>
                <button class="close-modal" id="closeOccurrenceModal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="occurrenceForm">
                    <input type="hidden" id="occurrenceId">
                    <input type="hidden" id="parentEventId">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="occurrenceDate">Date *</label>
                            <input type="date" id="occurrenceDate" required>
                        </div>
                        <div class="form-group">
                            <label for="occurrenceStatus">Status *</label>
                            <select id="occurrenceStatus" required>
                                <option value="scheduled">Scheduled</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="occurrenceStartTime">Start Time *</label>
                            <input type="time" id="occurrenceStartTime" required>
                        </div>
                        <div class="form-group">
                            <label for="occurrenceEndTime">End Time</label>
                            <input type="time" id="occurrenceEndTime">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="attendanceChecked"> Attendance Recorded
                        </label>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" id="cancelOccurrenceBtn">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Occurrence</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle Occurrences View
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const eventId = this.closest('tr').dataset.eventId;
                const occurrencesRow = document.getElementById(`occurrences-${eventId}`);

                if (occurrencesRow.style.display === 'none') {
                    occurrencesRow.style.display = 'table-row';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    occurrencesRow.style.display = 'none';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });

        // Event Modal Handling
        const eventModal = document.getElementById('eventModal');
        const addEventBtn = document.getElementById('addEventBtn');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');

        function openEventModal(event = null) {
            const modalTitle = document.getElementById('modalTitle');
            const form = document.getElementById('eventForm');

            if (event) {
                modalTitle.textContent = 'Edit Event';
                document.getElementById('eventId').value = event.id;
                document.getElementById('eventName').value = event.event_name;
                document.getElementById('eventDescription').value = event.event_description;
                document.getElementById('eventType').value = event.event_type;
                document.getElementById('eventStatus').value = event.status;
                document.getElementById('startDate').value = event.start_date;
                document.getElementById('startTime').value = event.start_time;
                document.getElementById('endDate').value = event.end_date || '';
                document.getElementById('endTime').value = event.end_time || '';
                document.getElementById('location').value = event.location || '';
                document.getElementById('volunteersNeeded').value = event.number_Volunteer_needed || 0;

                if (event.repeat) {
                    document.getElementById('isRecurring').checked = true;
                    document.getElementById('recurringOptions').style.display = 'block';
                    // Additional logic to set recurring options if needed
                }
            } else {
                modalTitle.textContent = 'Add New Event';
                form.reset();
            }

            eventModal.style.display = 'flex';
        }

        function closeEventModal() {
            eventModal.style.display = 'none';
        }

        // addEventBtn.addEventListener('click', () => openEventModal());
        // $('#addEventBtn').on('click', (e) => {
        //     e.preventDefault();
        //     console.log('clicked')
        // });
        closeModal.addEventListener('click', closeEventModal);
        cancelBtn.addEventListener('click', closeEventModal);

        // Recurring Event Toggle
        document.getElementById('isRecurring').addEventListener('change', function () {
            document.getElementById('recurringOptions').style.display = this.checked ? 'block' : 'none';
        });

        // Event Form Submission
        document.getElementById('eventForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const eventData = {
                id: document.getElementById('eventId').value,
                event_name: document.getElementById('eventName').value,
                event_description: document.getElementById('eventDescription').value,
                event_type: document.getElementById('eventType').value,
                status: document.getElementById('eventStatus').value,
                start_date: document.getElementById('startDate').value,
                start_time: document.getElementById('startTime').value,
                end_date: document.getElementById('endDate').value || null,
                end_time: document.getElementById('endTime').value || null,
                location: document.getElementById('location').value || null,
                number_Volunteer_needed: document.getElementById('volunteersNeeded').value || 0,
                repeat: document.getElementById('isRecurring').checked,
                repeat_frequency: document.getElementById('isRecurring').checked ?
                    document.getElementById('repeatFrequency').value : null,
                repeat_until: document.getElementById('isRecurring').checked ?
                    document.getElementById('repeatUntil').value : null
            };

            // Here you would typically make an AJAX call to your backend
            console.log('Saving event:', eventData);
            alert('Event saved successfully!');
            closeEventModal();

            // In a real app, you would refresh the data or update the table
        });

        // View Event
        function viewEvent(eventId) {
            // In a real app, this might open a detailed view or modal
            console.log('Viewing event:', eventId);
            alert(`Viewing event with ID: ${eventId}`);
        }

        // Edit Event
        function editEvent(eventId) {
            // In a real app, you would fetch the event data from your backend
            const event = {
                id: eventId,
                event_name: 'Sample Event',
                event_description: 'This is a sample event description',
                event_type: 'service',
                status: 'upcoming',
                start_date: '2023-06-15',
                start_time: '09:00',
                end_date: '2023-06-15',
                end_time: '12:00',
                location: 'Main Sanctuary',
                number_Volunteer_needed: 5,
                repeat: false
            };

            openEventModal(event);
        }

        // Delete Event
        function deleteEvent(eventId) {
            if (confirm('Are you sure you want to delete this event?')) {
                // In a real app, you would make an AJAX call to delete the event
                console.log('Deleting event:', eventId);
                alert(`Event with ID: ${eventId} deleted successfully!`);

                // In a real app, you would remove the row from the table
            }
        }

        // Occurrence Modal Handling
        const occurrenceModal = document.getElementById('occurrenceModal');
        const closeOccurrenceModal = document.getElementById('closeOccurrenceModal');
        const cancelOccurrenceBtn = document.getElementById('cancelOccurrenceBtn');

        function openOccurrenceModal(eventId, occurrence = null) {
            document.getElementById('parentEventId').value = eventId;

            if (occurrence) {
                document.getElementById('occurrenceId').value = occurrence.id;
                document.getElementById('occurrenceDate').value = occurrence.occurrence_date;
                document.getElementById('occurrenceStatus').value = occurrence.status;
                document.getElementById('occurrenceStartTime').value = occurrence.start_time;
                document.getElementById('occurrenceEndTime').value = occurrence.end_time || '';
                document.getElementById('attendanceChecked').checked = occurrence.attendance_checked;
            } else {
                document.getElementById('occurrenceForm').reset();
                document.getElementById('occurrenceId').value = '';
            }

            occurrenceModal.style.display = 'flex';
        }

        function closeOccurrenceModal() {
            occurrenceModal.style.display = 'none';
        }

        closeOccurrenceModal.addEventListener('click', closeOccurrenceModal);
        cancelOccurrenceBtn.addEventListener('click', closeOccurrenceModal);

        // Add Occurrence
        function addOccurrence(eventId) {
            openOccurrenceModal(eventId);
        }

        // Edit Occurrence
        function editOccurrence(occurrenceId) {
            // In a real app, you would fetch the occurrence data from your backend
            const occurrence = {
                id: occurrenceId,
                occurrence_date: '2023-06-18',
                status: 'scheduled',
                start_time: '09:00',
                end_time: '12:00',
                attendance_checked: false
            };

            openOccurrenceModal(null, occurrence);
        }

        // Delete Occurrence
        function deleteOccurrence(occurrenceId) {
            if (confirm('Are you sure you want to delete this occurrence?')) {
                // In a real app, you would make an AJAX call to delete the occurrence
                console.log('Deleting occurrence:', occurrenceId);
                alert(`Occurrence with ID: ${occurrenceId} deleted successfully!`);

                // In a real app, you would remove the row from the table
            }
        }

        // Occurrence Form Submission
        document.getElementById('occurrenceForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const occurrenceData = {
                id: document.getElementById('occurrenceId').value,
                event_id: document.getElementById('parentEventId').value,
                occurrence_date: document.getElementById('occurrenceDate').value,
                status: document.getElementById('occurrenceStatus').value,
                start_time: document.getElementById('occurrenceStartTime').value,
                end_time: document.getElementById('occurrenceEndTime').value || null,
                attendance_checked: document.getElementById('attendanceChecked').checked
            };

            // Here you would typically make an AJAX call to your backend
            console.log('Saving occurrence:', occurrenceData);
            alert('Occurrence saved successfully!');
            closeOccurrenceModal();

            // In a real app, you would refresh the data or update the table
        });

        // Search Functionality
        document.getElementById('searchInput').addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.events-table tbody tr:not(.occurrences-row)');

            rows.forEach(row => {
                const eventName = row.querySelector('.event-name').textContent.toLowerCase();
                const eventDescription = row.querySelector('.event-description').textContent.toLowerCase();

                if (eventName.includes(searchTerm) || eventDescription.includes(searchTerm)) {
                    row.style.display = '';
                    // Make sure to show/hide the corresponding occurrences row if it's currently visible
                    const eventId = row.dataset.eventId;
                    const occurrencesRow = document.getElementById(`occurrences-${eventId}`);
                    if (occurrencesRow && occurrencesRow.style.display === 'table-row') {
                        occurrencesRow.style.display = '';
                    }
                } else {
                    row.style.display = 'none';
                    // Hide the corresponding occurrences row if it exists
                    const eventId = row.dataset.eventId;
                    const occurrencesRow = document.getElementById(`occurrences-${eventId}`);
                    if (occurrencesRow) {
                        occurrencesRow.style.display = 'none';
                    }
                }
            });
        });
    </script>
@endsection