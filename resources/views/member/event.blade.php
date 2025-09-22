@extends('layouts.member')

@section('header')
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center">
            <h1 class="text-2xl font-bold text-primary">Events</h1>
            <p class="text-gray-500 mt-2 sm:mt-0">View all upcoming and past events and their occurrences</p>
        </div>
    </header>
@endsection

@section('content')

    <!-- Tabs Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <a href="#"
                    class="tab-link py-4 px-1 text-center border-b-2 font-medium text-sm transition-all duration-200"
                    data-tab="upcoming"
                    :class="{  'border-primary text-primary': activeTab === 'upcoming','border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'upcoming' }">
                    Upcoming Events
                </a>
                <a href="#"
                    class="tab-link py-4 px-1 text-center border-b-2 font-medium text-sm transition-all duration-200"
                    data-tab="attended"
                    :class="{'border-primary text-primary': activeTab === 'attended','border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'attended' }">
                    Attended Events
                </a>
                <a href="#"
                    class="tab-link py-4 px-1 text-center border-b-2 font-medium text-sm transition-all duration-200"
                    data-tab="missed"
                    :class="{  'border-primary text-primary': activeTab === 'missed', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'missed'}">
                    Missed Events
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Upcoming Events Tab -->
        <div id="upcoming-tab" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($upcomingEvents as $event)
                    @include('partials.event-card', ['event' => $event])
                @empty
                    <div class="col-span-full text-center py-16">
                        <i class="bi bi-calendar-x text-6xl text-gray-300 mb-4"></i>
                        <p class="text-lg text-gray-500">No upcoming events found.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Attended Events Tab -->
        <div id="attended-tab" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($attendedEvents as $event)
                    @if($event)
                        @include('partials.event-card', ['event' => $event])
                    @endif
                @empty
                    <div class="col-span-full text-center py-16">
                        <i class="bi bi-calendar-check text-6xl text-gray-300 mb-4"></i>
                        <p class="text-lg text-gray-500">No attended events found.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Missed Events Tab -->
        <div id="missed-tab" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($missedEvents as $event)
                    @if($event)
                        @include('partials.event-card', ['event' => $event])
                    @endif
                @empty
                    <div class="col-span-full text-center py-16">
                        <i class="bi bi-calendar-x text-6xl text-gray-300 mb-4"></i>
                        <p class="text-lg text-gray-500">No missed events found.</p>
                    </div>
                @endforelse
            </div>
        </div>
        @vite("resources/js/member-my-event.js")
    </main>
@endsection