<?php

namespace App\Helpers;

class EventHelper
{
    static public function getEventIdName($events)
    {
        return $events->select('id', 'name')->get();
    }
}