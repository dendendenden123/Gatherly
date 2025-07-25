<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('event_occurrences')->orderByDesc('id')->simplePaginate(5);
        $totalEvents = Event::query()->count();
        $upcomingEvents = Event::filter(['end_date' => now()->addMonth(), 'status' => 'upcoming'])->count();

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
}
