@extends('layouts.member')
@section('content')
    @section('header')
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center">
                <h1 class="text-2xl font-bold text-primary">Events</h1>
                <p class="text-gray-500 mt-2 sm:mt-0">View all upcoming and past events and their occurrences</p>
            </div>
        </header>
    @endsection

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
                <div
                    class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border-t-4 border-primary flex flex-col">
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex items-center justify-between mb-2">
                            <span
                                class="text-xs px-2 py-1 rounded bg-secondary text-white uppercase tracking-wide">{{ $event->event_type }}</span>
                            <span class="text-xs text-gray-400">{{ ucfirst($event->status) }}</span>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-1">{{ $event->event_name }}</h2>
                        <p class="text-gray-600 mb-2 line-clamp-2">{{ $event->event_description }}</p>
                        <div class="flex flex-wrap gap-2 text-xs mb-2">
                            <span class="bg-gray-100 px-2 py-1 rounded"><i class="bi bi-geo-alt text-accent"></i>
                                {{ $event->location }}</span>
                            <span class="bg-gray-100 px-2 py-1 rounded"><i class="bi bi-people text-primary"></i> Needed:
                                {{ $event->number_Volunteer_needed }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2 text-xs mb-2">
                            <span class="bg-gray-100 px-2 py-1 rounded"><i class="bi bi-calendar-event text-secondary"></i>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }} -
                                {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}</span>
                            <span class="bg-gray-100 px-2 py-1 rounded"><i class="bi bi-clock text-secondary"></i>
                                {{ $event->start_time }} - {{ $event->end_time }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2 text-xs mb-2">
                            <span class="bg-gray-100 px-2 py-1 rounded">Repeat: <span
                                    class="text-secondary font-semibold">{{ ucfirst($event->repeat) }}</span></span>
                        </div>
                        <div class="mt-2">
                            <span class="text-xs text-gray-400">Created: {{ $event->created_at }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 rounded-b-xl">
                        <h3 class="text-sm font-semibold text-secondary mb-2 flex items-center"><i
                                class="bi bi-calendar2-week mr-2"></i> Occurrences</h3>
                        @if($event->event_occurrences && count($event->event_occurrences))
                            <ul class="divide-y divide-gray-200 max-h-40 overflow-y-auto">
                                @foreach($event->event_occurrences as $occ)
                                    <li class="py-2 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-700"><i class="bi bi-calendar3"></i>
                                                {{ \Carbon\Carbon::parse($occ->occurrence_date)->format('M d, Y') }}</span>
                                            <span class="text-xs text-gray-500"><i class="bi bi-clock"></i>
                                                {{ $occ->start_time ? \Carbon\Carbon::createFromFormat('H:i:s', $occ->start_time)->format('h:i A') : 'N/A' }}
                                                -
                                                {{ $occ->end_time ? \Carbon\Carbon::createFromFormat('H:i:s', $occ->end_time)->format('h:i A') : 'N/A' }}</span>
                                        </div>
                                        <span
                                            class="text-xs mt-1 sm:mt-0 px-2 py-1 rounded {{ $occ->status === 'active' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }}">{{ ucfirst($occ->status) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-xs text-gray-400 italic">No occurrences found.</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <i class="bi bi-calendar-x text-6xl text-gray-300 mb-4"></i>
                    <p class="text-lg text-gray-500">No events found.</p>
                </div>
            @endforelse
        </div>
    </main>
@endsection