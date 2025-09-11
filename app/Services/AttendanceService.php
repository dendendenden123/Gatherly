<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\User;
use App\Models\EventOccurrence;
class AttendanceService
{

    public function getAllAttendancePaginated()
    {
        return Attendance::with(['user', 'event_occurrence'])->orderByDesc('updated_at')->paginate(5);
    }

    public function getFilteredAttendancesPaginated($request, $userId = null)
    {
        $from_date = $request->input('start_date') ?? now()->subYear();
        $to = $request->input('end_date') ?? now();

        $filters = [
            'search_by_name' => $request->input('search'),
            'start_date' => Carbon::parse($from_date),
            'end_date' => Carbon::parse($to),
            'status' => $request->input('status', '') === "*" ? '' : $request->input('status'),
            'event_id' => $request->input('event_id'),
            'user_id' => $userId
        ];

        return Attendance::filter($filters)
            ->orderByDesc('id')
            ->simplePaginate(6);
    }

    public function countUserAttendances($userID)
    {
        return Attendance::filter(['user_id' => $userID, 'status' => 'present'])->count();
    }

    public function getAttendanceGrowthRateLastMonth($user_id)
    {
        $countLastMonthAttendance = Attendance::filter([
            'user_id' => $user_id,
            'status' => 'present',
            'start_date' => now()->subMonth()->startOfMonth(),
            'end_date' => now()->subMonth()->endOfMonth()
        ])->count();

        $countLastTwoMonthAttendance = Attendance::filter([
            'user_id' => $user_id,
            'status' => 'present',
            'start_date' => now()->subMonths(2)->startOfMonth(),
            'end_date' => now()->subMonths(2)->endOfMonth()
        ])->count();

        if ($countLastTwoMonthAttendance === 0 && $countLastMonthAttendance === 0) {
            return ['value' => 0, 'sign' => 'negative'];
        }
        if ($countLastMonthAttendance === 0) {
            return ['value' => 100, 'sign' => 'negative'];
        }
        if ($countLastTwoMonthAttendance === 0) {
            return ['value' => 100, 'sign' => 'positive'];
        }

        if ($countLastMonthAttendance >= $countLastTwoMonthAttendance) {
            $countDifference = $countLastMonthAttendance - $countLastTwoMonthAttendance;
            return ['value' => (intval(($countDifference / $countLastMonthAttendance) * 100)), 'sign' => 'positive'];
        }

        $countDifference = $countLastTwoMonthAttendance - $countLastMonthAttendance;
        return ['value' => (intval(($countDifference / $countLastTwoMonthAttendance) * 100)), 'sign' => 'negative'];
    }


    //====================================
    //===Calculate a user's attendance rate (percentage of present days) for last month
    //===================================
    public function getAttendanceRateLastMonth($user_id)
    {
        $presentCount = Attendance::filter([
            'user_id' => $user_id,
            'status' => 'present',
            'start_date' => now()->subMonth()->startOfMonth(),
            'end_date' => now()->subMonth()->endOfMonth()
        ])->count();

        $absentCount = Attendance::filter([
            'user_id' => $user_id,
            'status' => 'absent',
            'start_date' => now()->subMonth()->startOfMonth(),
            'end_date' => now()->subMonth()->endOfMonth()
        ])->count();

        $total = $presentCount + $absentCount;

        if ($total === 0) {
            return 0; // Prevent division by zero
        }

        return intval(($presentCount / $total) * 100);
    }

    //====================================
    //===Record all absent users for a given event occurrence and mark attendance as checked
    //===================================
    public function storeMultipleAbsentRecord($eventOccurenceId)
    {
        $presentUser = Attendance::where('event_occurrence_id', $eventOccurenceId)->where('status', 'present')->pluck('user_id');
        $absentUser = User::pluck('id')->diff($presentUser);

        foreach ($absentUser as $id) {
            Attendance::create([
                'user_id' => $id,
                'event_occurrence_id' => $eventOccurenceId,
                'service_date' => now(),
                'check_in_time' => now()->format('H:i'),
                'status' => 'absent'
            ]);
        }
        EventOccurrence::find($eventOccurenceId)->update([
            'attendance_checked' => 1
        ]);
    }

    //====================================
    //===Check if a user already has an attendance record for a specific event occurrence
    //===================================
    public function isUserAlreadyRecorded($userId, $eventOccurenceId)
    {
        return Attendance::where('event_occurrence_id', $eventOccurenceId)->where('user_id', $userId)->exists();
    }
}