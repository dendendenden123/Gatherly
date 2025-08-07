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
            <form method="POST" action="{{ route('admin.events.store') }}" id="eventForm" class="divide-y divide-gray-200">
                @csrf
                @method('POST')
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
                            icon: 'Error',
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
                            <input type="text" name="event_name" id="eventName" value="{{ old('event_name')}}" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- Event Description -->
                        <div>
                            <label for="eventDescription"
                                class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="eventDescription" name="event_description" rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>{{  old('event_description') }}</textarea>
                        </div>

                        <!-- Event Type and Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Event Type -->
                            <div>
                                <label for="eventType" class="block text-sm font-medium text-gray-700">Event Type
                                    *</label>
                                <select id="eventType" name="event_type"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                    <option value="">Select a type</option>
                                    <option value="Baptism" {{ old('event_type') == 'Baptism' ? 'selected' : '' }}>
                                        Baptism
                                    </option>
                                    <option value="Charity Event" {{ old('event_type') == 'Charity Event' ? 'selected' : '' }}>
                                        Charity Event
                                    </option>
                                    <option value="Christian Family Organization (CFO) activity" {{ old('event_type') == 'Christian Family Organization (CFO) activity' ? 'selected' : '' }}>
                                        Christian Family Organization (CFO) activity
                                    </option>
                                    <option value="Evangelical Mission" {{ old('event_type') == 'Evangelical Mission' ? 'selected' : '' }}>
                                        Evangelical Mission
                                    </option>
                                    <option value="Inauguration of New Chapels/ Structure" {{ old('event_type') == 'Inauguration of New Chapels/ Structure' ? 'selected' : '' }}>
                                        Inauguration of New Chapels/Structure
                                    </option>
                                    <option value="Meeting" {{ old('event_type') == 'Meeting' ? 'selected' : '' }}>
                                        Meeting
                                    </option>
                                    <option value="Panata" {{ old('event_type') == 'Panata' ? 'selected' : '' }}>
                                        Panata
                                    </option>
                                    <option value="Weddings" {{ old('event_type') == 'Weddings' ? 'selected' : '' }}>
                                        Weddings
                                    </option>
                                    <option value="Worship Service" {{ old('event_type') == 'Worship Service' ? 'selected' : '' }}>
                                        Worship Service
                                    </option>
                                </select>

                            </div>

                            <!-- Event Status -->
                            <div>
                                <label for="eventStatus" class="block text-sm font-medium text-gray-700">Status
                                    *</label>
                                <select id="eventStatus" name="status"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming
                                    </option>
                                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing
                                    </option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed
                                    </option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Location & Volunteers -->
                <div class="px-6 py-5 space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <!-- Date & Time -->
                <div class="px-6 py-5 space-y-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Date & Time</h3>
                    <div id='calendar' data-events="{{$existingEvents}}"></div>

                    <!-- Modal (hidden by default) -->
                    <div id="myModal"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                        <div class="bg-white rounded-lg p-6 w-96 shadow-lg relative">
                            <!-- Start Date -->
                            <div>
                                <label for="startTime" class="block text-sm font-medium text-gray-700">Start Date *</label>
                                <input type="date" name="start_date" id="startDate" value="{{ old('start_date') }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="endTime" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="endDate" value="{{ old('end_date') }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                            </div>
                            <!-- Start Time -->
                            <div>
                                <label for="startTime" class="block text-sm font-medium text-gray-700">Start Time *</label>
                                <input type="time" name="start_time" id="startTime" value="{{ old('start_time') }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <!-- End Time -->
                            <div>
                                <label for="endTime" class="block text-sm font-medium text-gray-700">End Time</label>
                                <input type="time" name="end_time" id="endTime" value="{{ old('end_time') }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="repeatFrequency"
                                    class="block text-sm font-medium text-gray-700">Frequency</label>
                                <select id="repeatFrequency" name="repeat"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="once" {{ old('repeat') == 'once' ? 'selected' : '' }}>Once</option>
                                    <option value="daily" {{ old('repeat') == 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ old('repeat') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ old('repeat') == 'monthly' ? 'selected' : '' }}>Monthly
                                    </option>
                                    <option value="yearly" {{ old('repeat') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </div>
                            <button
                                class="closeModal absolute top-2 right-2 text-gray-500 hover:text-black text-xl">&times;</button>
                            <button class="closeModal mt-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                Confirm
                            </button>
                        </div>
                    </div>
                    <!-- end of line -->
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 text-right">
                    <a href="{{ route('admin.events.index') }}">
                        <button type="button"
                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                    </a>
                    <button id="submitForm" type="submit"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-save mr-2"></i> Save Event
                    </button>

                </div>
            </form>
        </div>

        <div id="viewEvent"
            class="hidden fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 transition-opacity duration-300 ease-in-out">
            <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-2xl relative overflow-hidden">
                <!-- Decorative accent bar -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-green-500"></div>

                <div class="space-y-5">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-2">Event Details</h3>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500">Event name</span>
                            <span id='viewEventName' class="text-gray-800 font-medium mt-1">Annual Conference</span>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500">Description</span>
                            <span id='viewEventDescription' class=" text-gray-600 mt-1">Our yearly gathering of industry
                                leaders
                                and innovators</span>
                        </div>

                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-28">Status</span>
                            <span id='viewEventStatus'
                                class=" px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                        </div>

                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-28">Location</span>
                            <span class="text-gray-800"><span id='viewEventLocation'><i>NA</i></span>
                        </div>

                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-28">Date</span>
                            <span class="text-gray-800"><span id='viewEventDate'><i>NA</i></span>
                        </div>

                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-28">Start at</span>
                            <span class="text-gray-800"><span id='viewEventStartTime'><i>NA</i></span>
                        </div>

                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-28">End at</span>
                            <span class="text-gray-800"><span id='viewEventEndTime'><i>NA</i></span></span>
                        </div>

                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-500 w-28">Event Duration</span>
                            <span class="text-gray-800"><span id='viewEventStartDate'></span> - <span
                                    id='viewEventEndDate'></span> | <span id='viewEventRepeat'></span></span>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button
                            class="closeViewEventModal px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/admin-events-create.js')

@endsection