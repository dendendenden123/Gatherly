<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatherly - Events Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-green: #2ecc71;
            --dark-green: #27ae60;
            --accent-red: #e74c3c;
            --light-gray: #f5f5f5;
            --medium-gray: #ecf0f1;
            --dark-gray: #95a5a6;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --purple: #9b59b6;
            --blue: #3498db;
            --orange: #e67e22;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: var(--light-gray);
            color: var(--text-dark);
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-title h1 {
            font-size: 1.5rem;
            color: var(--primary-green);
        }

        /* Main Layout */
        .main-container {
            display: flex;
            flex-grow: 1;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: white;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .nav-menu {
            margin-top: 30px;
        }

        .nav-item {
            padding: 12px 0;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .nav-item i {
            margin-right: 10px;
            width: 20px;
            color: var(--text-light);
        }

        .nav-item.active {
            color: var(--primary-green);
            font-weight: 500;
        }

        .nav-item.active i {
            color: var(--primary-green);
        }

        /* Main Content */
        .content {
            flex-grow: 1;
            padding: 30px;
        }

        /* View Toggle */
        .view-toggle {
            display: flex;
            background-color: var(--medium-gray);
            border-radius: 6px;
            padding: 5px;
            margin-bottom: 25px;
            max-width: fit-content;
        }

        .view-option {
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .view-option.active {
            background-color: white;
            color: var(--primary-green);
            font-weight: 500;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* Events Dashboard */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .card-title {
            font-weight: 600;
            color: var(--text-dark);
        }

        .card-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 5px;
        }

        .card-footer {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        /* Calendar View */
        .calendar-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .calendar-nav {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .calendar-nav-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background-color: var(--medium-gray);
        }

        .calendar-month {
            font-weight: 500;
            min-width: 150px;
            text-align: center;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .calendar-day-header {
            text-align: center;
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text-light);
            padding: 5px;
        }

        .calendar-day {
            aspect-ratio: 1;
            border-radius: 6px;
            padding: 5px;
            border: 1px solid var(--medium-gray);
            cursor: pointer;
            transition: all 0.2s;
        }

        .calendar-day:hover {
            background-color: var(--light-gray);
        }

        .calendar-day.empty {
            background-color: transparent;
            border: none;
            cursor: default;
        }

        .calendar-day.today {
            background-color: rgba(46, 204, 113, 0.1);
            border-color: var(--primary-green);
        }

        .calendar-day-number {
            font-size: 0.9rem;
            margin-bottom: 3px;
        }

        .calendar-event {
            background-color: var(--primary-green);
            color: white;
            font-size: 0.7rem;
            padding: 2px 5px;
            border-radius: 4px;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Events List */
        .events-list-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .events-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .events-list-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 8px 15px 8px 35px;
            border: 1px solid var(--medium-gray);
            border-radius: 20px;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-gray);
        }

        .events-list {
            display: grid;
            gap: 15px;
        }

        .event-card {
            display: flex;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .event-date {
            width: 70px;
            background-color: var(--primary-green);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .event-day {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .event-month {
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .event-details {
            flex-grow: 1;
            background-color: white;
            padding: 15px;
        }

        .event-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .event-time {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .event-location {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .event-description {
            font-size: 0.9rem;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .event-actions {
            display: flex;
            gap: 10px;
        }

        .event-action-btn {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .edit-btn {
            background-color: var(--primary-green);
            color: white;
            border: none;
        }

        .delete-btn {
            background-color: transparent;
            color: var(--accent-red);
            border: 1px solid var(--accent-red);
        }

        /* Add Event Button */
        .add-event-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-green);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 10;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-light);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: var(--primary-green);
            color: white;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-green);
            color: var(--primary-green);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 15px;
            }

            .content {
                padding: 20px;
            }

            .dashboard-cards {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .add-event-btn {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="header-title">
            <h1>Gatherly - Events Management</h1>
        </div>
        <div class="user-avatar"></div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="nav-menu">
                <div class="nav-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </div>
                <div class="nav-item">
                    <i class="fas fa-user-tie"></i>
                    <span>Officers</span>
                </div>
                <div class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Members</span>
                </div>
                <div class="nav-item active">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Events</span>
                </div>
                <div class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
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
            <div class="calendar-container" id="calendarView">
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
            <div class="events-list-container" id="listView" style="display: none;">
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
</body>

</html>