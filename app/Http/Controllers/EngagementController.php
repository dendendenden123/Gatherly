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
                'roles' => implode(", ", $this->getRoleNames($user->officers->pluck('role')->toArray())),
                'roles_count' => $user->officers_count
            ];
        });
    }

    private function getRoleNames(array $roleNumbers): array
    {
        return array_map(function ($roleNumber) {
            switch ($roleNumber) {
                case 0:
                    return 'None';
                case 1:
                    return 'Minister';
                case 2:
                    return 'Head Deacon';
                case 3:
                    return 'Deacon';
                case 4:
                    return 'Deaconess';
                case 5:
                    return 'Choir';
                case 6:
                    return 'Secretary';
                case 7:
                    return 'Finance';
                case 8:
                    return 'SCAN';
                case 9:
                    return 'Overseer';
                default:
                    return 'Unknown';
            }
        }, $roleNumbers);
    }
}
