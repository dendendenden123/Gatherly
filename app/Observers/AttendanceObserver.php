<?php

namespace App\Observers;

use Throwable;
use Carbon\Carbon;
use App\Helpers\AttendanceHelper;
use App\Models\Attendance;
use App\Models\User;

class AttendanceObserver
{
    public function created(Attendance $attendance)
    {
        try {
            $worshipDaysCount = AttendanceHelper::getWorshipDaysCountLastMonth();
            $newlyAddedUserId = Attendance::latest()->value('user_id');

            $user = User::with([
                'attendances' => function ($attendance) {
                    $attendance->whereHas('event_occurrence.event', function ($event) {
                        $event->where('event_type', 'Worship Service');
                    })
                        ->where('status', 'present')
                        ->whereBetween('created_at', [
                            Carbon::now()->subMonth()->startOfMonth(),
                            Carbon::now()->subMonth()->endOfMonth()
                        ]);
                },
                'attendances.event_occurrence.event'
            ])->find($newlyAddedUserId);

            if ($user->created_at < Carbon::now()->subMonth()) {
                if ($user->attendances->count() == '0') {

                    logger('user has been inactive', ['user' => $user]);
                    return $user->update(['status' => 'inactive']);
                } else if ($user->attendances->count() <= ($worshipDaysCount / 2)) {

                    logger('user has been partially-active', ['user' => $user]);
                    return $user->update(['status' => 'partially-active']);
                } else if ($user->attendances->count() >= $worshipDaysCount) {
                    return $user->update(['status' => 'active']);
                }
            }
        } catch (Throwable $e) {
            \Log::error('Error updating users status', ['error' => $e]);
        }

    }
}
