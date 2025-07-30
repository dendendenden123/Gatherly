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
                'event_description' => 'nullable|string',
                'event_type' => 'required|string|max:100',
                'status' => 'required|in:upcoming,completed,cancelled',
                'start_date' => 'required|date',
                'start_time' => 'required|date_format:H:i:s',
                'end_date' => 'required|date|after_or_equal:start_date',
                'end_time' => 'required|date_format:H:i:s',
                'location' => 'required|string|max:255',
                'number_Volunteer_needed' => 'required|integer|min:1',
                'repeat' => 'nullable|in:daily,weekly,monthly,yearly',
            ]);

            Event::findOrFail($id)->update($validated);

            return redirect()->back()->with(['success' => 'Event updated successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update event: ' . $e->getMessage()]);
        }

    }

    public function destroy($id)
    {
        $Event = Event::findOrFail($id);
        logger($Event);
        $Event->delete();

        return redirect()->route('admin.events.index')->with(['success' => 'Event deleted succesfully']);
    }

}
