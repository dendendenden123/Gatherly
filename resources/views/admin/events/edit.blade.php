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
            <form method="POST" action="{{ route('admin.events.update', $event->id) }}" id="eventForm"
                class="divide-y divide-gray-200">
                @csrf
                @method('PUT')
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: '{{ session('success') }}',
                            confirmButtonColor: '#3085d6',
                        });
                    </script>
                @elseif(session('error'))
                    <script>
                        Swal.fire({
                            icon: 'Failed',
                            title: 'Failed!',
                            text: '{{ session('error') }}',
                            confirmButtonColor: '#d63030ff',
                        });
                    </script>
                @endif

                <!-- Basic Information -->
                <div class="px-6 py-5 space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Event Name -->
                        <div>
                            <label for="eventName" class="block text-sm font-medium text-gray-700">Event Name *</label>
                            <input type="text" name="event_name" id="eventName" value="{{ $event->event_name }}" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- Event Description -->
                        <div>
                            <label for="eventDescription"
                                class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="eventDescription" name="event_description" rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                                                                                                                                                                                                                                                                                                                      {{ $event->event_description}}
                                                                                                                                                                                                                                                                                                                                                   </textarea>
                        </div>

                        <!-- Event Type and Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Event Type -->
                            <div>
                                <label for="eventType" class="block text-sm font-medium text-gray-700">Event Type
                                    *</label>
                                <select id="eventType" name="event_type" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select a type</option>
                                    <option value="Baptism" {{ $event->event_type == "Baptism" ? 'selected' : ''}}>
                                        Baptism
                                    </option>
                                    <option value="Charity Event" {{ $event->event_type == "Charity Event" ? 'selected' : ''}}>
                                        Charity Event
                                    </option>
                                    <option value="Christian Family Organization (CFO) activity" {{ $event->event_type == "Christian Family Organization (CFO) activity" ? 'selected' : ''}}>
                                        Christian Family Organization (CFO) activity
                                    </option>
                                    <option value="Evangelical Mission">Evangelical Mission

                                    </option>
                                    <option value="Inauguration of New Chapels/ Structure" {{ $event->event_type == "Inauguration of New Chapels/ Structure" ? 'selected' : ''}}>
                                        Inauguration of New Chapels/Structure
                                    </option>
                                    <option value="Meeting" {{ $event->event_type == "Meeting" ? 'selected' : ''}}>
                                        Meeting
                                    </option>
                                    <option value="Panata" {{ $event->event_type == "Panata" ? 'selected' : ''}}>
                                        Panata
                                    </option>
                                    <option value="Weddings" {{ $event->event_type == "Weddings" ? 'selected' : ''}}>
                                        Weddings
                                    </option>
                                    <option value="Worship Service" {{ $event->event_type == "Worship Service" ? 'selected' : '' }}>
                                        Worship Service
                                    </option>
                                </select>

                            </div>

                            <!-- Event Status -->
                            <div>
                                <label for="eventStatus" class="block text-sm font-medium text-gray-700">Status
                                    *</label>
                                <select id="eventStatus" name="status" required
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
                            <input type="date" name="start_date" id="startDate" value="{{ $event->start_date }}" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- Start Time -->
                        <div>
                            <label for="startTime" class="block text-sm font-medium text-gray-700">Start Time *</label>
                            <input type="time" name="start_time" id="startTime" value="{{ $event->start_time }}" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="endDate" value="{{ $event->end_date }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="endTime" class="block text-sm font-medium text-gray-700">End Time</label>
                            <input type="time" name="end_time" id="endTime" value="{{ $event->end_time }}"
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
                            <input type="text" name="location" id="location" value="{{ $event->location }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- Volunteers Needed -->
                        <div>
                            <label for="volunteersNeeded" class="block text-sm font-medium text-gray-700">Volunteers
                                Needed</label>
                            <input type="number" name="number_Volunteer_needed" id="volunteersNeeded" min="0"
                                value="{{ $event->number_Volunteer_needed }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Recurring Event Options -->
                <div class="px-6 py-5 space-y-6">
                    <div class="relative flex items-start">
                        <div class="flex items-center h-5">
                            <input id="isRecurring" type="checkbox"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ $event->repeat != 'once' ? 'checked' : ''  }}>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="isRecurring" class="font-medium text-gray-700">Recurring Event</label>
                            <p class="text-gray-500">Check this if the event repeats on a schedule</p>
                        </div>
                    </div>

                    <!-- Recurring Options (hidden by default) -->
                    <div id="recurringOptions"
                        class="{{ $event->repeat != 'once' ? '' : 'hidden'  }} space-y-6 bg-gray-50 p-4 rounded-md">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Frequency -->
                            <div>
                                <label for="repeatFrequency"
                                    class="block text-sm font-medium text-gray-700">Frequency</label>
                                <select id="repeatFrequency" name="repeat"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="once" {{ $event->repeat == 'once' ? 'selected' : ''}}>Once</option>
                                    <option value="daily" {{ $event->repeat == 'daily' ? 'selected' : ''}}>Daily</option>
                                    <option value="weekly" {{ $event->repeat == 'weekly' ? 'selected' : ''}}>Weekly</option>
                                    <option value="monthly" {{ $event->repeat == 'monthly' ? 'selected' : ''}}>Monthly
                                    </option>
                                    <option value="yearly" {{ $event->repeat == 'yearly' ? 'selected' : ''}}>yearly</option>
                                </select>
                            </div>

                            <!-- Repeat Until -->
                            <div>
                                <label for="repeatUntil" class="block text-sm font-medium text-gray-700">Repeat
                                    Until</label>
                                <input type="date" name="repeatUntil" id="repeatUntil" value="{{ $event->end_date }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 text-right">
                    <a href="{{ route('admin.events.index') }}">
                        <button type="button"
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                    </a>
                    <button type="submit"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-save mr-2"></i> Save Event
                    </button>

                </div>
            </form>
        </div>
    </div>
    </div>
@endsection