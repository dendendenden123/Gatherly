<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
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

    public function create()
    {
        return view('admin.events.create');
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id'
        ]);

        $event = Event::findOrFail($validated['event_id']);
        $event->delete();
        $events = Event::filter($request->all())->orderByDesc('id')->simplePaginate(5);
        $totalEvents = Event::query()->count();
        $upcomingEvents = Event::filter(['end_date' => now()->addMonth(), 'status' => 'upcoming'])->count();


        try {
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

        } catch (\Exception $e) {
            \Log::error('Error deleting event', [
                'event_id' => $validated['event_id'],
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Failed to delete event.'
            ], 500);
        }
    }

}
