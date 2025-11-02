<div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border-t-4 border-primary flex flex-col">
    <div class="p-5 flex-1 flex flex-col">
        <div class="flex items-center justify-between mb-2">
            <span
                class="text-xs px-2 py-1 rounded bg-secondary text-white uppercase tracking-wide">{{ $event->event->event_type }}</span>
        </div>
        <h2 class="text-lg font-semibold text-gray-900 mb-1">{{ $event->event->event_name }}</h2>
        <p class="text-gray-600 mb-2 line-clamp-2">{{ $event->event_description }}</p>
        <div class="flex flex-wrap gap-2 text-xs mb-2">
            <span class="bg-gray-100 px-2 py-1 rounded"><i class="bi bi-geo-alt text-accent"></i>
                {{ $event->location }}</span>
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
</div>