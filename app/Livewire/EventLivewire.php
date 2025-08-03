<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Event;

class EventLivewire extends Component
{
    public function render()
    {
        // return view('livewire.event-livewire');
        return view('admin.events.create');
    }

    #[On('addEvent')]
    public function addEvent($event_name, $start_date, $end_date)
    {
        dd($event_name);
    }
}
