@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/events/index.css') }}">
@endsection

@section('header')
    <div class="header">
        <div class="header-title">
            <h1>Gatherly - Events Management</h1>
        </div>
        <div class="user-avatar"></div>
    </div>
@endsection


<!-- Header -->

@section('content')
    <!-- View Toggle -->
    <div class="view-toggle">
        <div class="view-option active" data-view="calendar">Calendar</div>
        <div class="view-option" data-view="list">List View</div>
    </div>

    <!-- Events Dashboard -->
    <div class="dashboard-cards">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-title">Upcoming Events</div>
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="card-value">12</div>
            <div class="card-footer">Next 30 days</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-title">Weekly Services</div>
                <i class="fas fa-church"></i>
            </div>
            <div class="card-value">3</div>
            <div class="card-footer">Recurring weekly</div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-title">Volunteers Needed</div>
                <i class="fas fa-hands-helping"></i>
            </div>
            <div class="card-value">5</div>
            <div class="card-footer">Events requiring help</div>
        </div>
    </div>

    <!-- Calendar View -->
    <div class="calendar-container" id="calendarView" style="display: none;">
        <div class="calendar-header">
            <div class="calendar-title">June 2023</div>
            <div class="calendar-nav">
                <div class="calendar-nav-btn">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="calendar-month">June 2023</div>
                <div class="calendar-nav-btn">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>

        <div class="calendar-grid">
            <div class="calendar-day-header">Sun</div>
            <div class="calendar-day-header">Mon</div>
            <div class="calendar-day-header">Tue</div>
            <div class="calendar-day-header">Wed</div>
            <div class="calendar-day-header">Thu</div>
            <div class="calendar-day-header">Fri</div>
            <div class="calendar-day-header">Sat</div>

            <!-- Calendar Days -->
            <div class="calendar-day empty"></div>
            <div class="calendar-day empty"></div>
            <div class="calendar-day empty"></div>
            <div class="calendar-day">
                <div class="calendar-day-number">1</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">2</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">3</div>
                <div class="calendar-event">Youth Group</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">4</div>
            </div>

            <!-- Week 2 -->
            <div class="calendar-day">
                <div class="calendar-day-number">5</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">6</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">7</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">8</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">9</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">10</div>
                <div class="calendar-event">Men's Breakfast</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">11</div>
                <div class="calendar-event">Sunday Service</div>
            </div>

            <!-- Week 3 -->
            <div class="calendar-day">
                <div class="calendar-day-number">12</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">13</div>
                <div class="calendar-event">Bible Study</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">14</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">15</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">16</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">17</div>
            </div>
            <div class="calendar-day today">
                <div class="calendar-day-number">18</div>
                <div class="calendar-event">Sunday Service</div>
                <div class="calendar-event">Baptism Class</div>
            </div>

            <!-- Week 4 -->
            <div class="calendar-day">
                <div class="calendar-day-number">19</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">20</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">21</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">22</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">23</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">24</div>
                <div class="calendar-event">Women's Retreat</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">25</div>
                <div class="calendar-event">Sunday Service</div>
            </div>

            <!-- Week 5 -->
            <div class="calendar-day">
                <div class="calendar-day-number">26</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">27</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">28</div>
                <div class="calendar-event">Prayer Meeting</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">29</div>
            </div>
            <div class="calendar-day">
                <div class="calendar-day-number">30</div>
            </div>
            <div class="calendar-day empty"></div>
            <div class="calendar-day empty"></div>
        </div>
    </div>

    <!-- Events List View (Initially Hidden) -->
    <div class="events-list-container" id="listView" style="display: block;">
        <div class="events-list-header">
            <div class="events-list-title">Upcoming Events</div>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search events...">
            </div>
        </div>

        <div class="events-list">
            <!-- Event Card 1 -->
            <div class="event-card">
                <div class="event-date" style="background-color: #9b59b6;">
                    <div class="event-day">18</div>
                    <div class="event-month">Jun</div>
                </div>
                <div class="event-details">
                    <div class="event-title">Sunday Service</div>
                    <div class="event-time">
                        <i class="fas fa-clock"></i> 9:00 AM - 12:00 PM
                    </div>
                    <div class="event-location">
                        <i class="fas fa-map-marker-alt"></i> Main Sanctuary
                    </div>
                    <div class="event-description">
                        Weekly Sunday worship service with communion. Guest speaker: Pastor Michael Brown.
                    </div>
                    <div class="event-actions">
                        <button class="event-action-btn edit-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="event-action-btn delete-btn">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Event Card 2 -->
            <div class="event-card">
                <div class="event-date" style="background-color: #e67e22;">
                    <div class="event-day">18</div>
                    <div class="event-month">Jun</div>
                </div>
                <div class="event-details">
                    <div class="event-title">Baptism Class</div>
                    <div class="event-time">
                        <i class="fas fa-clock"></i> 1:00 PM - 3:00 PM
                    </div>
                    <div class="event-location">
                        <i class="fas fa-map-marker-alt"></i> Room 205
                    </div>
                    <div class="event-description">
                        Mandatory class for all candidates planning to be baptized next month.
                    </div>
                    <div class="event-actions">
                        <button class="event-action-btn edit-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="event-action-btn delete-btn">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Event Card 3 -->
            <div class="event-card">
                <div class="event-date" style="background-color: #3498db;">
                    <div class="event-day">24</div>
                    <div class="event-month">Jun</div>
                </div>
                <div class="event-details">
                    <div class="event-title">Women's Retreat</div>
                    <div class="event-time">
                        <i class="fas fa-clock"></i> 4:00 PM - 8:00 PM
                    </div>
                    <div class="event-location">
                        <i class="fas fa-map-marker-alt"></i> Fellowship Hall
                    </div>
                    <div class="event-description">
                        Annual women's retreat with guest speaker Sarah Johnson. Dinner provided.
                    </div>
                    <div class="event-actions">
                        <button class="event-action-btn edit-btn">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="event-action-btn delete-btn">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Add Event Button -->
    <div class="add-event-btn" id="addEventBtn">
        <i class="fas fa-plus"></i>
    </div>

    <!-- Add Event Modal -->
    <div class="modal" id="addEventModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Add New Event</div>
                <button class="close-modal" id="closeModal">&times;</button>
            </div>

            <form id="eventForm">
                <div class="form-group">
                    <label for="eventTitle">Event Title *</label>
                    <input type="text" id="eventTitle" placeholder="Enter event name" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="eventStartDate">Start Date *</label>
                        <input type="date" id="eventStartDate" required>
                    </div>
                    <div class="form-group">
                        <label for="eventStartTime">Start Time *</label>
                        <input type="time" id="eventStartTime" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="eventEndDate">End Date</label>
                        <input type="date" id="eventEndDate">
                    </div>
                    <div class="form-group">
                        <label for="eventEndTime">End Time</label>
                        <input type="time" id="eventEndTime">
                    </div>
                </div>

                <div class="form-group">
                    <label for="eventLocation">Location</label>
                    <input type="text" id="eventLocation" placeholder="Where is the event happening?">
                </div>

                <div class="form-group">
                    <label for="eventCategory">Category</label>
                    <select id="eventCategory">
                        <option value="service">Worship Service</option>
                        <option value="meeting">Meeting</option>
                        <option value="class">Class/Study</option>
                        <option value="social">Social Event</option>
                        <option value="outreach">Outreach</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="eventDescription">Description</label>
                    <textarea id="eventDescription" placeholder="Details about the event..."></textarea>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" id="isRecurring"> Recurring Event
                    </label>
                    <div id="recurringOptions" style="display: none; margin-top: 10px;">
                        <select id="recurringFrequency">
                            <option value="weekly">Weekly</option>
                            <option value="biweekly">Bi-Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                        <input type="number" id="recurringEndAfter" placeholder="End after X occurrences"
                            style="margin-top: 5px;">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-outline" id="cancelAddEvent">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Event</button>
                </div>
            </form>
        </div>
    </div>

@endsection

<script>
    // View Toggle
    document.querySelectorAll('.view-option').forEach(option => {
        option.addEventListener('click', function () {
            document.querySelector('.view-option.active').classList.remove('active');
            this.classList.add('active');

            if (this.dataset.view === 'calendar') {
                document.getElementById('calendarView').style.display = 'block';
                document.getElementById('listView').style.display = 'none';
            } else {
                document.getElementById('calendarView').style.display = 'none';
                document.getElementById('listView').style.display = 'block';
            }
        });
    });

    // Modal Handling
    const addEventBtn = document.getElementById('addEventBtn');
    const addEventModal = document.getElementById('addEventModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelAddEvent');

    addEventBtn.addEventListener('click', () => {
        addEventModal.style.display = 'flex';
    });

    closeModal.addEventListener('click', () => {
        addEventModal.style.display = 'none';
    });

    cancelBtn.addEventListener('click', () => {
        addEventModal.style.display = 'none';
    });

    // Recurring Event Toggle
    document.getElementById('isRecurring').addEventListener('change', function () {
        document.getElementById('recurringOptions').style.display = this.checked ? 'block' : 'none';
    });

    // Form Submission
    document.getElementById('eventForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Get form values
        const title = document.getElementById('eventTitle').value;
        const startDate = document.getElementById('eventStartDate').value;
        const startTime = document.getElementById('eventStartTime').value;
        const endDate = document.getElementById('eventEndDate').value;
        const endTime = document.getElementById('eventEndTime').value;
        const location = document.getElementById('eventLocation').value;
        const category = document.getElementById('eventCategory').value;
        const description = document.getElementById('eventDescription').value;
        const isRecurring = document.getElementById('isRecurring').checked;
        const frequency = isRecurring ? document.getElementById('recurringFrequency').value : null;
        const endAfter = isRecurring ? document.getElementById('recurringEndAfter').value : null;

        // In a real app, this would send data to your backend
        console.log('Adding event:', {
            title,
            start: `${startDate} ${startTime}`,
            end: endDate && endTime ? `${endDate} ${endTime}` : null,
            location,
            category,
            description,
            isRecurring,
            frequency,
            endAfter
        });

        alert(`Event "${title}" added successfully!`);
        addEventModal.style.display = 'none';
        this.reset();
    });

    // Calendar Day Click
    document.querySelectorAll('.calendar-day:not(.empty)').forEach(day => {
        day.addEventListener('click', function () {
            const date = this.querySelector('.calendar-day-number').textContent;
            alert(`Viewing events for June ${date}, 2023`);
            // In a real app, this would show events for that day
        });
    });

    // Edit buttons
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const eventTitle = this.closest('.event-details').querySelector('.event-title').textContent;
            alert(`Editing "${eventTitle}" event`);
            // In a real app, this would open an edit modal with pre-filled data
        });
    });

    // Delete buttons
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const eventTitle = this.closest('.event-details').querySelector('.event-title').textContent;
            if (confirm(`Are you sure you want to delete "${eventTitle}" event?`)) {
                alert(`"${eventTitle}" event has been deleted.`);
                // In a real app, this would make an API call to delete the event
            }
        });
    });
</script>