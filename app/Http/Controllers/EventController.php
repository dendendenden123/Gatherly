<?php

namespace App\Http\Controllers;
use App\Models\EventOccurrence;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $request)
    {
        logger($request->all());
        $events = Event::filter($request->all())->orderByDesc('id')->simplePaginate(5);
        $totalEvents = Event::query()->count();
        $upcomingEvents = Event::filter(['end_date' => now()->addMonth(), 'status' => 'upcoming'])->count();
        if ($request->ajax()) {
            $eventsListView = view('admin.events.index-events-list', compact('events'))->render();
            return response()->json([
                'list' => $eventsListView
            ]);
        }
        return view('admin.events.index', compact(
            'events',
            'totalEvents',
            'upcomingEvents'
        ));
    }

    public function show(Request $request, $id)
    {
        $event = Event::findOrFail($id)->first();
        $eventOccurrences = EventOccurrence::where('event_id', $id)->orderByDesc('id')->simplePaginate(5);
        if ($request->ajax()) {
            $showEventsListView = view('admin.events.show-events-list', compact('eventOccurrences'))->render();
            return response()->json([
                'list' => $showEventsListView,
            ]);
        }
        return view('admin.events.show', compact('event', 'eventOccurrences'));
    }

    public function create(Request $request)
    {
        $existingEvents = Event::with(['event_occurrences'])->get();
        if ($request->ajax()) {
            return response()->json(['data' => $existingEvents]);
        }
        return view('admin.events.create', compact('existingEvents'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'event_name' => 'req uired|string|max:255',
                'event_description' => 'required|string',
                'event_type' => 'required|string|max:100',
                'status' => 'required|in:upcoming,ongoing,completed,cancelled',
                'start_date' => 'required|date',
                'start_time' => 'nullable|date_format:H:i',
                'end_date' => 'required|date|after_or_equal:start_date',
                'end_time' => 'nullable|date_format:H:i',
                'location' => 'nullable|string|max:255',
                'number_Volunteer_needed' => 'nullable|integer|min:1',
                'repeat' => 'nullable|in:once,daily,weekly,monthly,yearly',
            ]);
            Event::create($validated);
            return redirect()->back()->with(['success' => 'Event created successfully']);
        } catch (\Exception $e) {
            \Log::error('Failed to create event. ', [$e]);
            return redirect()->back()->with(['error' => 'Failed to create event: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'event_name' => 'required|string|max:255',
                'event_description' => 'required|string',
                'event_type' => 'required|string|max:100',
                'status' => 'required|in:upcoming,completed,cancelled',
                'start_date' => 'required|date',
                'start_time' => 'nullable|date_format:H:i:s',
                'end_date' => 'required|date|after_or_equal:start_date',
                'end_time' => 'nullable|date_format:H:i:s',
                'location' => 'nullable|string|max:255',
                'number_Volunteer_needed' => 'nullable|integer|min:1',
                'repeat' => 'nullable|in:once,daily,weekly,monthly,yearly',
            ]);
            Event::findOrFail($id)->update($validated);
            return redirect()->back()->with(['success' => 'Event updated successfully']);
        } catch (\Exception $e) {
            \Log::error('Failed to Update event. ', [$e]);
            return redirect()->back()->withInput()->with(['error' => 'Failed to update event: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $Event = Event::findOrFail($id);
        $Event->delete();
        return redirect()->route('admin.events.index')->with(['success' => '']);
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
        ]);
        try {
            Event::whereIn('id', $validated['ids'])->delete();
            return response()->json(['success' => "Event deleted succesfully"]);
        } catch (\Exception $e) {
            \Log::error('Failed to delete events:', [$e]);
            return response()->json(['error' => "Failed to delete events"]);

        }
    }

}
