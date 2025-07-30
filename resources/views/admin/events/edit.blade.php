@extends('layouts.admin')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection


@section('header')
<!-- Header -->
<header>
    <div class="max-w-7xl mx-auto px-4 py-1 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="page-tite">
            <h1 class="text-xl font-semibold text-gray-900">Events Management</h1>
            <p class="text-gray-500">Efficiently monitor event progress and participation</p>
        </div>


        <div class="flex items-center space-x-4">
            <a href=" {{ route('admin.events.create') }}">
                <button class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md text-sm">
                    <i class="bi bi-plus mr-1"></i> New Record
                </button>
            </a>
        </div>
    </div>
</header>
@endSection

@section('content')

    <!-- Main Content -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Form Header -->
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Event Details</h3>
                <p class="mt-1 text-sm text-gray-500">Fill in the details below to create a new event.</p>
            </div>

            <!-- Form -->
            <form id="eventForm" class="divide-y divide-gray-200">
                <!-- Basic Information -->
                <div class="px-6 py-5 space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Event Name -->
                        <div>
                            <label for="eventName" class="block text-sm font-medium text-gray-700">Event Name *</label>
                            <input type="text" name="eventName" id="eventName" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- Event Description -->
                        <div>
                            <label for="eventDescription"
                                class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="eventDescription" name="eventDescription" rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <!-- Event Type and Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Event Type -->
                            <div>
                                <label for="eventType" class="block text-sm font-medium text-gray-700">Event Type
                                    *</label>
                                <select id="eventType" name="eventType" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select a type</option>
                                    <option value="service">Worship Service</option>
                                    <option value="meeting">Meeting</option>
                                    <option value="class">Class/Study</option>
                                    <option value="social">Social Event</option>
                                    <option value="outreach">Outreach</option>
                                </select>
                            </div>

                            <!-- Event Status -->
                            <div>
                                <label for="eventStatus" class="block text-sm font-medium text-gray-700">Status
                                    *</label>
                                <select id="eventStatus" name="eventStatus" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="upcoming">Upcoming</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Date & Time -->
                <div class="px-6 py-5 space-y-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Date & Time</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Start Date -->
                        <div>
                            <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date *</label>
                            <input type="date" name="startDate" id="startDate" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- Start Time -->
                        <div>
                            <label for="startTime" class="block text-sm font-medium text-gray-700">Start Time *</label>
                            <input type="time" name="startTime" id="startTime" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="endDate" id="endDate"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="endTime" class="block text-sm font-medium text-gray-700">End Time</label>
                            <input type="time" name="endTime" id="endTime"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Location & Volunteers -->
                <div class="px-6 py-5 space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- Volunteers Needed -->
                        <div>
                            <label for="volunteersNeeded" class="block text-sm font-medium text-gray-700">Volunteers
                                Needed</label>
                            <input type="number" name="volunteersNeeded" id="volunteersNeeded" min="0"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Recurring Event Options -->
                <div class="px-6 py-5 space-y-6">
                    <div class="relative flex items-start">
                        <div class="flex items-center h-5">
                            <input id="isRecurring" name="isRecurring" type="checkbox"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="isRecurring" class="font-medium text-gray-700">Recurring Event</label>
                            <p class="text-gray-500">Check this if the event repeats on a schedule</p>
                        </div>
                    </div>

                    <!-- Recurring Options (hidden by default) -->
                    <div id="recurringOptions" class="hidden space-y-6 bg-gray-50 p-4 rounded-md">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Frequency -->
                            <div>
                                <label for="repeatFrequency"
                                    class="block text-sm font-medium text-gray-700">Frequency</label>
                                <select id="repeatFrequency" name="repeatFrequency"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>

                            <!-- Repeat Until -->
                            <div>
                                <label for="repeatUntil" class="block text-sm font-medium text-gray-700">Repeat
                                    Until</label>
                                <input type="date" name="repeatUntil" id="repeatUntil"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 text-right">
                    <button type="button"
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-save mr-2"></i> Save Event
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script>
        // Toggle recurring options
        document.getElementById('isRecurring').addEventListener('change', function () {
            const recurringOptions = document.getElementById('recurringOptions');
            if (this.checked) {
                recurringOptions.classList.remove('hidden');
            } else {
                recurringOptions.classList.add('hidden');
            }
        });

        // Form submission
        document.getElementById('eventForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Collect form data
            const formData = {
                eventName: document.getElementById('eventName').value,
                eventDescription: document.getElementById('eventDescription').value,
                eventType: document.getElementById('eventType').value,
                eventStatus: document.getElementById('eventStatus').value,
                startDate: document.getElementById('startDate').value,
                startTime: document.getElementById('startTime').value,
                endDate: document.getElementById('endDate').value,
                endTime: document.getElementById('endTime').value,
                location: document.getElementById('location').value,
                volunteersNeeded: document.getElementById('volunteersNeeded').value,
                isRecurring: document.getElementById('isRecurring').checked,
                repeatFrequency: document.getElementById('isRecurring').checked ?
                    document.getElementById('repeatFrequency').value : null,
                repeatUntil: document.getElementById('isRecurring').checked ?
                    document.getElementById('repeatUntil').value : null
            };

            // Here you would typically make an AJAX call to your backend
            console.log('Form data:', formData);
            alert('Event created successfully!');

            // Redirect to events list or show success message
            // window.location.href = '/admin/events';
        });
    </script>
@endsection