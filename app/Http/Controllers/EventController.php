<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\EventStoreRequest;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Models\EventOccurrence;
use App\Models\Event;
use App\Models\Role;
use App\Models\Log;

class EventController extends Controller
{
    protected EventService $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }
    public function index(Request $request)
    {
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
        $roles = Role::select('id', 'name')->orderBy('id')->get();
        $existingEvents = Event::with(['event_occurrences'])->get();

        if ($request->ajax()) {
            return response()->json(['data' => $existingEvents]);
        }
        return view('admin.events.create', compact('existingEvents', 'roles'));
    }

    public function store(EventStoreRequest $request)
    {
        try {
            $overlapEventCounts = $this->eventService->eventAndUserTypeOverlap($request)->count();
            $overlappingEventNames = $this->eventService->eventAndUserTypeOverlap($request)->map(function ($eventOccurrence) {
                return $eventOccurrence->event?->event_name;
            })->join(', ');

            if ($overlapEventCounts > 0) {
                return back()->withErrors(
                    'Failed! Your event overlaps with these existing events: '
                    . $overlappingEventNames
                );
            }

            $validated = $request->validated();
            $event = Event::create($validated);

            //logs action
            Log::create([
                'user_id' => Auth::id(),
                'action' => 'create',
                'description' => 'create new event. event : ' . $event
            ]);

            return redirect()->back()->with(['success' => 'Event created successfully']);
        } catch (\Throwable $e) {
            \Log::error('Failed to create event. ', [$e]);
            return back()->withErrors('Failed to create event: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(EventStoreRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            Event::findOrFail($id)->update($validated);

            //logs action
            Log::create([
                'user_id' => Auth::id(),
                'action' => 'update',
                'description' => 'update an event. event id: ' . $id,
            ]);

            return redirect()->back()->with(['success' => 'Event updated successfully']);
        } catch (\Throwable $e) {
            \Log::error('Failed to Update event. ', [$e]);
            return redirect()->back()->withInput()->with(['error' => 'Failed to update event: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $Event = Event::findOrFail($id);
        $Event->delete();

        //logs action
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'description' => 'delete an event. event id: ' . $id,
        ]);

        return redirect()->route('admin.events.index')->with(['success' => '']);
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
        ]);
        try {
            Event::whereIn('id', $validated['ids'])->delete();

            //logs action
            Log::create([
                'user_id' => Auth::id(),
                'action' => 'delete',
                'description' => 'delete multiple events. event ids: ' . $validated['ids'],
            ]);

            return response()->json(['success' => "Event deleted succesfully"]);
        } catch (\Throwable $e) {
            \Log::error('Failed to delete events:', [$e]);
            return response()->json(['error' => "Failed to delete events"]);

        }
    }

    public function showMyEvents()
    {
        $userId = auth()->id();
        $upcomingEvents = $this->eventService->getUpcomingEvent();
        $attendedEvents = $this->eventService->getEventsAttendedByUser($userId);
        $missedEvents = $this->eventService->getEventsMissedByUser($userId);

        return view('member.event', compact('upcomingEvents', 'attendedEvents', 'missedEvents'));
    }
}
