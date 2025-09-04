<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;

class EngagementController extends Controller
{
    public function index(Request $request)
    {
        $userEngagement = self::getUserEngagement($request);
        return view('admin.engagements.index', compact('userEngagement'));
    }

    private function getUserEngagement($request)
    {
        $users = User::withCount(['officers', 'attendances'])
            ->with('attendances', 'officers')
            ->orderByDesc('officers_count')
            ->orderByDesc('attendances_count')
            ->limit(10)
            ->get();

        return $users->map(function ($user) {
            return [
                'created_at' => optional($user->created_at)->format('M d, Y') ?? '',
                'user_name' => $user->first_name . ' ' . $user->last_name,
                'attendance' => Attendance::getAttendanceRateLastMonth($user->id),
                'roles' => $user->officers->map(function ($officer) {
                    return $officer->role_description;
                })->implode(', '),
                'roles_count' => $user->officers_count
            ];
        });
    }
}
