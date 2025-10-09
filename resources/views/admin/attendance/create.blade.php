<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Church Attendance | Check-In</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href={{ asset('css/admin/attendance/create.css') }}>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2ecc71',
                        secondary: '#27ae60',
                        accent: '#e74c3c',
                        'light-gray': '#f8fafc',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-light-gray min-h-screen">
    <div class="container mx-auto px-4 py-6 max-w-6xl">
        <!-- Header Section -->
        <header class="mb-8 text-center">
            <div class="flex items-center justify-center mb-4">
                <div class="h-12 w-12 rounded-full gradient-bg flex items-center justify-center mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Church Attendance Check-In</h1>
            </div>
            <p class="text-gray-600 max-w-2xl mx-auto">Efficiently record member attendance for services and events with
                our streamlined check-in system.</p>
        </header>

        <!-- Tab Navigation -->
        <div class="bg-white rounded-t-xl card-shadow mb-0">
            <div class="flex border-b border-gray-200">
                <button class="tab-button active" data-tab="enrollment-tab">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Enrollment</span>
                    </div>
                </button>
                <button class="tab-button" data-tab="scan-tab">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Scan</span>
                    </div>
                </button>
                <button class="tab-button" data-tab="manual-tab">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Manual</span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white rounded-b-xl card-shadow p-6">
            <!-- Enrollment Tab -->
            <div id="enrollment-tab" class="tab-content active">
                <div class="max-w-2xl mx-auto">
                    <div class="flex items-center mb-6">
                        <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-800">Enroll New Member</h2>
                    </div>

                    <form id="enrollForm" method="POST" enctype="multipart/form-data"
                        action="{{ route('admin.attendance.enroll') }}">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" id="email" name="email" placeholder="member@example.com"
                                    data-email-verify-url="{{ route('admin.attendance.isEmailValidForEnrollment') }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <div class="emailVerifyFeedback"></div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Member Photo</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="photo-upload"
                                        class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-3"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-sm text-gray-500"><span class="font-semibold">Click to
                                                    upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 5MB</p>
                                        </div>
                                        <input id="photo-upload" name="photo" type="file" class="hidden" required />
                                    </label>
                                </div>
                            </div>

                            <button type="submit" id="emailVerifyBtn"
                                class="w-full btn-primary py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-lg relative"
                                disabled>
                                <span id="enrollBtnSpinner" class="hidden absolute left-4">
                                    <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                    </svg>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span id="enrollBtnText">Enroll Member</span>
                            </button>
                            <div id="enrollErrorMsg" class="text-red-600 text-sm mt-2 hidden"></div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Scan Tab -->
            <div id="scan-tab" class="tab-content">
                <div class="max-w-2xl mx-auto">
                    <div class="flex items-center mb-6">
                        <div class="h-10 w-10 rounded-full bg-secondary flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-800">Quick Check-In</h2>
                    </div>

                    <form id="scanForm" method="POST" enctype="multipart/form-data"
                        action="{{ route('admin.attendance.scan') }}">
                        @csrf
                        <div class="space-y-6">
                            <div class="text-center bg-gray-50 rounded-xl p-6 border border-gray-200">
                                <p class="text-gray-600 mb-4">Use camera to quickly check-in members with facial
                                    recognition</p>

                                <button type="button" id="openCameraBtn"
                                    class="w-full btn-secondary py-4 rounded-lg font-medium flex items-center justify-center gap-2 pulse-animation text-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Scan with Camera
                                </button>
                            </div>


                            <div class="mt-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Event</label>
                                <div class="flex items-center gap-4">
                                    <div class="relative flex-grow">
                                        <select id="eventNameSelection" name="event_occurrence_id"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent appearance-none bg-white">
                                            @if($todaysScheduleEvent->isEmpty())
                                                <option value="">No scheduled events for today</option>
                                            @else
                                                <option value="">Select Event</option>
                                                @foreach ($todaysScheduleEvent as $eventOccurrence)
                                                    <option value="{{ $eventOccurrence->id }}">
                                                        {{ $eventOccurrence->event->event_name }}
                                                        ({{$eventOccurrence->StartTimeFormatted}})
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                            </svg>
                                        </div>
                                    </div>

                                    @if($todaysScheduleEvent->isEmpty())
                                        <a href="{{ route('admin.events.create') }}"
                                            class="text-primary hover:text-secondary font-medium text-sm whitespace-nowrap">
                                            Create New Event
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                                <div class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-blue-500 mt-0.5 mr-2 flex-shrink-0" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm text-blue-700">After capturing a photo, click "Submit Attendance"
                                        to process the facial recognition and check-in the member.</p>
                                </div>
                            </div>

                            <button type="submit" id="scanSubmitBtn"
                                class="w-full btn-primary py-3 rounded-lg font-medium flex items-center justify-center gap-2 text-lg relative">
                                <span id="scanBtnSpinner" class="hidden absolute left-4">
                                    <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                    </svg>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span id="scanBtnText">Submit Attendance</span>
                            </button>
                            <div id="scanErrorMsg" class="text-red-600 text-sm mt-2 hidden"></div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Manual Tab -->
            <div id="manual-tab" class="tab-content">
                <div class="max-w-4xl mx-auto">
                    <div class="flex items-center mb-6">
                        <div class="h-10 w-10 rounded-full bg-accent flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-800">Manual Attendance</h2>
                    </div>

                    <!-- Search and Filters -->
                    <form method="GET" action="{{ route('admin.attendance.create') }}" id="manual-form" class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Member Locale</label>
                                <div class="relative">
                                    <select id="locale-select" name='locale'
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent appearance-none bg-white">
                                        <option value="">-- Select Locale --</option>
                                        <option>Local ng Alcantara</option>
                                        <option>Local ng Argao</option>
                                        <option>Local ng Asturias</option>
                                        <option>Local ng Badian</option>
                                        <option>Local ng Balamban</option>
                                        <option>Local ng Barili</option>
                                        <option>Local ng Bato</option>
                                        <option>Local ng Binlod</option>
                                        <option>Local ng Bulasa</option>
                                        <option>Local ng Bulongan</option>
                                        <option>Local ng Cantao-an</option>
                                        <option>Local ng Carcar City</option>
                                        <option>Local ng Colon</option>
                                        <option>Local ng Dalaguete</option>
                                        <option>Local ng Don Juan Climaco Sr.</option>
                                        <option>Local ng Dumanjug</option>
                                        <option>Local ng Gen. Climaco</option>
                                        <option>Local ng Langtad</option>
                                        <option>Local ng Langub</option>
                                        <option>Local ng Lutopan</option>
                                        <option>Local ng Mainggit</option>
                                        <option>Local ng Malabuyoc</option>
                                        <option>Local ng Manguiao</option>
                                        <option>Local ng Mantalongon</option>
                                        <option>Local ng Naga</option>
                                        <option>Local ng Panadtaran</option>
                                        <option>Local ng Pinamungajan</option>
                                        <option>Local ng Ronda</option>
                                        <option>Local ng San Isidro</option>
                                        <option>Local ng Sangat</option>
                                        <option>Local ng Sibonga</option>
                                        <option>Local ng Sta Lucia</option>
                                        <option>Local ng Tag-Amakan</option>
                                        <option>Local ng Talaga</option>
                                        <option>Local ng Talavera</option>
                                        <option>Local ng Tiguib</option>
                                        <option>Local ng Toledo City</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Search Members</label>
                                <div class="relative">
                                    <input type="text" id="member-search" name="member-search"
                                        placeholder="Enter name or member ID"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                        autocomplete="off">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <label id="responeMessage" class="text-xs text-gray-500 mt-1"></label>

                                    <!-- Autocomplete Dropdown -->
                                    <div id="autocomplete-results" data
                                        class="hidden absolute z-10 mt-1 w-full bg-white rounded-lg shadow-lg border border-gray-200 max-h-60 overflow-auto">
                                        <div
                                            class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 flex justify-between">
                                            <span><i>No results found</i></span>
                                            <span class="text-gray-500 font-mono"><i>NA</i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Event</label>
                            <div class="flex items-center gap-4">
                                <div class="relative flex-grow">
                                    <select id="manualEventNameSelection" name="event_occurrence_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent appearance-none bg-white">
                                        @if($todaysScheduleEvent->isEmpty())
                                            <option value="">No scheduled events for today</option>
                                        @else
                                            <option value="">Select Event</option>
                                            @foreach ($todaysScheduleEvent as $eventOccurrence)
                                                <option value="{{ $eventOccurrence->id }}">
                                                    {{ $eventOccurrence->event->event_name }}
                                                    ({{$eventOccurrence->StartTimeFormatted}})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                    </div>
                                </div>

                                @if($todaysScheduleEvent->isEmpty())
                                    <a href="{{ route('admin.events.create') }}"
                                        class="text-primary hover:text-secondary font-medium text-sm whitespace-nowrap">
                                        Create New Event
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <!-- Member Display -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-6 border border-gray-200">
                        <div class="flex items-center space-x-5">
                            <!-- Member Photo -->
                            <div class="flex-shrink-0">
                                <div
                                    class="h-24 w-24 rounded-full bg-gray-200 overflow-hidden border-4 border-white shadow-md">
                                    <img src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&auto=format&fit=crop&w=128&h=128&q=80"
                                        alt="Member photo" class="h-full w-full object-cover">
                                </div>
                            </div>

                            <!-- Member Info -->
                            <div id="selected-member" class="flex-grow">
                                <h3 id='name-selected' class="text-xl font-semibold text-gray-800">Michael Johnson
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600 mt-2">
                                    <div class="flex items-center">
                                        <span class="font-medium w-24">Member ID:</span>
                                        <span id='id-selected' class="font-semibold text-gray-800">0</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-medium w-24">Birthdate:</span>
                                        <span id='birthdate-selected' class="font-semibold text-gray-800">January 1,
                                            1999</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-medium w-24">Email:</span>
                                        <span id='email-selected'
                                            class="font-semibold text-gray-800">user@gmail.com</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-medium w-24">Phone:</span>
                                        <span id='phone-selected' class="font-semibold text-primary">09*****</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                        <button id="event-done-btn"
                            class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary transition-colors">
                            Event Done
                        </button>
                        <button id="absent-attendnace-btn" action="{{ route('admin.attendance.store') }}"
                            class="px-5 py-2.5 rounded-lg btn-danger flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Mark as Absent
                        </button>

                        <button id="present-attendnace-btn" action="{{ route('admin.attendance.store') }}"
                            class="px-5 py-2.5 rounded-lg btn-primary flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Mark as Present
                        </button>
                    </div>
                </div>

                <!-- Recent Check-Ins Section -->
                <div class="create-recent-attendance-list mt-8">
                    @include('admin.attendance.create-recent-attendance-list')
                </div>
            </div>
        </div>
    </div>

    <!-- Camera Modal -->
    <div id="cameraModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 hidden fade-in">
        <div
            class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md relative flex flex-col items-center camera-modal">
            <button id="closeCameraModal"
                class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-xl bg-white rounded-full h-8 w-8 flex items-center justify-center transition-colors">
                &times;
            </button>
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Scan Attendance - Take Photo</h3>

            <div class="relative w-full h-64 mb-4 rounded-xl overflow-hidden bg-black flex items-center justify-center">
                <video id="cameraPreview" autoplay playsinline class="w-full h-full object-cover"></video>
                <div class="absolute inset-0 border-2 border-white rounded-xl pointer-events-none"></div>
            </div>

            <canvas id="cameraCanvas" class="hidden"></canvas>

            <div class="flex space-x-3 w-full">
                <button id="capturePhotoBtn"
                    class="flex-1 btn-primary py-3 rounded-lg font-medium flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    </svg>
                    Capture Photo
                </button>
            </div>

            <div id="cameraError" class="text-red-500 mt-3 text-center hidden"></div>
        </div>
    </div>

    <!-- SweetAlert2 Pop-up for Session Messages -->
    @if(session('success'))
        <script>
            $(function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: @json(session('success')),
                    timer: 2500,
                    showConfirmButton: false
                });
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            $(function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: @json(session('error')),
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif
    <script>
        $(function () {
            // Scan form loading/error
            $('#scanForm').on('submit', function (e) {
                $('#scanSubmitBtn').prop('disabled', true);
                $('#scanBtnSpinner').removeClass('hidden');
                $('#scanBtnText').text('Submitting...');
                $('#scanErrorMsg').addClass('hidden').text('');
                // Optionally, handle AJAX here
                // e.preventDefault();
                // $.ajax({ ... })
                //   .done(function() { ... })
                //   .fail(function(xhr) {
                //       $('#scanErrorMsg').removeClass('hidden').text('Failed to submit attendance. Please try again.');
                //       $('#scanSubmitBtn').prop('disabled', false);
                //       $('#scanBtnSpinner').addClass('hidden');
                //       $('#scanBtnText').text('Submit Attendance');
                //   });
            });
        });
    </script>
    @vite("resources/js/admin-attendance-create.js")
</body>

</html>