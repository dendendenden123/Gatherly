<?php

namespace App\Services;
use App\Models\Log;

class LogService
{
    public function logFilter($request)
    {
        $userName = $request['username'] ?? null;
        $actionType = $request['action_type'] ?? null;
        $dateFrom = $request['date_from'] ?? null;
        $dateTo = $request['date_to'] ?? null;

        return Log::with('user')
            ->when($userName, function ($query) use ($userName) {
                $query->whereHas('user', function ($q) use ($userName) {
                    $q->where('name', 'like', "%{$userName}%");
                });
            })
            ->when($actionType, function ($query) use ($actionType) {
                $query->where('action_type', $actionType);
            })
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            });
    }
}