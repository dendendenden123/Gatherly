<?php

namespace App\Services;
use App\Models\Log;

class LogService
{
    public function filterLogs($request)
    {
        $userName = $request->input('search_input');
        $dateFrom = $request->input('start_date');
        $dateTo = $request->input('end_date');
        $userType = $request->input('user_type');

        // Collect selected action types
        $actionTypes = ['login', 'logout', 'create', 'update', 'delete'];

        if ($request->hasAny(['filter-login', 'filter-logout', 'filter-create', 'filter-update', 'filter-delete', 'filter-request'])) {
            $actionTypes = [];
            if ($request->has('filter-login'))
                $actionTypes[] = 'login';
            if ($request->has('filter-logout'))
                $actionTypes[] = 'logout';
            if ($request->has('filter-create'))
                $actionTypes[] = 'create';
            if ($request->has('filter-update'))
                $actionTypes[] = 'update';
            if ($request->has('filter-delete'))
                $actionTypes[] = 'delete';
        }


        // Query with conditional filters
        $logs = Log::with('user.officers.role')
            ->when($userName, function ($query) use ($userName) {
                $query->whereHas('user', function ($q) use ($userName) {
                    $q->where(function ($q) use ($userName) {
                        $q->where('first_name', 'like', "%{$userName}%")
                            ->orWhere('middle_name', 'like', "%{$userName}%")
                            ->orWhere('last_name', 'like', "%{$userName}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$userName}%"])
                            ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE ?", ["%{$userName}%"]);
                    });
                });

            })
            ->when(!empty($actionTypes), function ($query) use ($actionTypes) {
                $query->whereIn('action', $actionTypes);
            })
            ->when(empty($actionTypes), function ($query) {
                $query->whereRaw('0 = 1'); // Always false condition
            })
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->when($userType, function ($query) use ($userType) {
                $query->whereHas('user.officers', function ($officer) use ($userType) {
                    $officer->whereHas('role', function ($role) use ($userType) {
                        $role->whereIn('id', (array) $userType);
                    });
                });
            });

        return $logs;
    }

}