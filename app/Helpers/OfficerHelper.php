<?php

namespace App\Helpers;

class OfficerHelper
{
    public static function countTotalOfficer($officerCollection)
    {
        return $officerCollection->count();
    }
}