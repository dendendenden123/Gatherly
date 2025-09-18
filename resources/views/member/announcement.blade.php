@extends('layouts.member')
@section('header')
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900">Announcements & Events</h1>
            <p class="text-sm text-gray-500">Stay updated with church activities</p>
        </div>
    </header>
@endsection

@section('content')
    <!-- Main Content -->
    <main class="announcement max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <a href="#" class="tab-active py-4 px-1 text-sm font-medium">
                    Upcoming Events
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-700 py-4 px-1 text-sm font-medium">
                    Recent Announcements
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-700 py-4 px-1 text-sm font-medium">
                    Event Calendar
                </a>
            </nav>
        </div>

        <!-- Upcoming Events Section -->
        <div class="mb-10">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Upcoming Events</h2>
                <button class="text-primary hover:text-secondary font-medium flex items-center">
                    <i class="bi bi-calendar-plus mr-1"></i> Add to Calendar
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse(($events ?? []) as $event)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden event-card transition">
                        <div class="relative h-40 bg-gradient-to-r from-primary to-secondary">
                            @php
                                $start = $event->start_date ? \Carbon\Carbon::parse($event->start_date) : null;
                                $end = $event->end_date ? \Carbon\Carbon::parse($event->end_date) : null;
                                $dateBadge = $start ? $start->format('M d') : '';
                                if ($start && $end && !$start->isSameDay($end)) {
                                    $dateBadge .= ' - ' . $end->format('M d');
                                }
                            @endphp
                            <div class="absolute top-4 left-4 bg-white text-primary text-sm font-bold px-3 py-1 rounded">
                                {{ $dateBadge ?: 'TBA' }}
                            </div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <h3 class="text-xl font-bold">{{ $event->event_name }}</h3>
                                <p class="text-sm opacity-90">
                                    @if ($event->start_time)
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                        @if ($event->end_time)
                                            - {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                        @endif
                                    @else
                                        Schedule TBA
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="p-4">
                            <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit($event->event_description, 130) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">{{ $event->event_type }}</span>
                                <div class="flex space-x-2">
                                    <button class="text-gray-400 hover:text-primary" title="Share">
                                        <i class="bi bi-share"></i>
                                    </button>
                                    <button class="text-gray-400 hover:text-primary" title="Bookmark">
                                        <i class="bi bi-bookmark"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                                <button class="text-primary hover:text-secondary text-sm font-medium flex items-center">
                                    <i class="bi bi-info-circle mr-1"></i> Details
                                </button>
                                <button class="bg-primary hover:bg-secondary text-white px-3 py-1 rounded-md text-sm">
                                    RSVP
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3">
                        <div class="bg-white rounded-lg p-6 border text-center text-gray-600">No upcoming events yet.</div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Announcements Section -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Recent Announcements</h2>
                <button class="text-primary hover:text-secondary font-medium flex items-center">
                    <i class="bi bi-bell mr-1"></i> Notification Settings
                </button>
            </div>

            <div class="space-y-4">
                @forelse(($notifications ?? []) as $note)
                    <div class="bg-white rounded-lg shadow-md p-6 announcement-card transition">
                        <div class="flex items-start">
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-full mr-4">
                                <i class="bi bi-megaphone text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $note->subject }}</h3>
                                        <p class="text-sm text-gray-500">
                                            Posted {{ optional($note->created_at)->format('M d, Y') }}
                                            @if(!empty($note->recipient_group))
                                                • For: {{ ucwords($note->recipient_group) }}
                                            @endif
                                        </p>
                                    </div>
                                    @if(!empty($note->category))
                                        <span class="text-xs bg-primary bg-opacity-10 text-primary px-2 py-1 rounded">{{ ucfirst($note->category) }}</span>
                                    @endif
                                </div>
                                <p class="mt-2 text-gray-600">{{ $note->message }}</p>
                                <div class="mt-4 flex items-center space-x-4 text-sm">
                                    <a href="#" class="text-primary hover:text-secondary flex items-center">
                                        <i class="bi bi-share mr-1"></i> Share
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg p-6 border text-center text-gray-600">No announcements yet.</div>
                @endforelse

                @if(!empty($notifications) && count($notifications) >= 15)
                    <!-- View More Button -->
                    <div class="text-center mt-6">
                        <a href="{{ route('admin.notifications.index', ['tab' => 'announcements']) }}"
                           class="inline-block border border-primary text-primary hover:bg-primary hover:text-white px-6 py-2 rounded-md font-medium transition">
                            View All Announcements
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>


    <script>
        // Tab functionality
        const tabs = document.querySelectorAll('.announcement nav a');
        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                tabs.forEach(t => t.classList.remove('tab-active'));
                tab.classList.add('tab-active');
                // Here you would typically load the content for the selected tab
            });
        });
    </script>
@endsection