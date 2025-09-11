<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $table = "attendances";

    protected $casts = [
        'check_in_time' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event_occurrence()
    {
        return $this->belongsTo(EventOccurrence::class);
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M d Y');
    }

    public function getFormattedCheckInTimeAttribute()
    {
        return $this->check_in_time ? $this->check_in_time->format('h:i A') : 'N/A';
    }
    public function scopeFilter($query, $filters)
    {
        $from = $filters['start_date'] ?? now()->subCentury();
        $to = $filters['end_date'] ?? now();
        $userId = $filters['user_id'] ?? null;
        $eventId = $filters['event_id'] ?? null;
        $searchByName = $filters['search_by_name'] ?? null;
        $status = $filters['status'] ?? null;

        return $query->with(['event_occurrence.event', 'user'])
            ->whereBetween('updated_at', [$from, $to])
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->whereHas('user', function ($query) use ($searchByName) {
                $query->when($searchByName, function ($q) use ($searchByName) {
                    $q->whereRaw("CONCAT(first_name, ' ',last_name) LIKE ?", ["%{$searchByName}%"])
                        ->orWhere('first_name', 'LIKE', "%{$searchByName}%")
                        ->orWhere('last_name', 'LIKE', "%{$searchByName}%");
                });
            })
            ->whereHas("event_occurrence.event", function ($query) use ($eventId) {
                $query->when($eventId, function ($q) use ($eventId) {
                    $q->where('id', $eventId);
                });
            });
    }

    public static function getAggregatedChartData($filters)
    {
        $weekly = Null;
        $monthly = Null;
        $yearly = Null;
        $aggregate = $filters['aggregate'] ?? 'monthly'; //default
        $totalMembers = User::count();

        if ($aggregate === 'weekly') {
            $weekly = true;
        } else if ($aggregate === 'yearly') {
            $yearly = true;
        } else if ($aggregate === 'monthly') {
            $monthly = true;
        }

        return static::filter($filters)
            ->when($weekly, function ($query) {
                $query->selectRaw("YEAR(updated_at) as year, WEEK(updated_at, 1) as week, COUNT(*) as total, COUNT(CASE WHEN status = 'present' THEN 1 END) AS present, COUNT(DISTINCT  event_occurrence_id) as event_count")
                    ->groupBy('year', 'week')
                    ->orderBy('year')
                    ->orderBy('week');
            })
            ->when($monthly, function ($query) {
                $query->selectRaw("DATE_FORMAT(updated_at, '%Y-%m') as month, COUNT(*) as total, COUNT(CASE WHEN status = 'present' THEN 1 END) AS present, COUNT(DISTINCT  event_occurrence_id) as event_count")
                    ->groupBy('month')
                    ->orderBy('month');
            })
            ->when($yearly, function ($query) {
                $query->selectRaw("YEAR(updated_at) as year, COUNT(*) as total, COUNT(CASE WHEN status = 'present' THEN 1 END) AS present, COUNT(DISTINCT  event_occurrence_id) as event_count")
                    ->groupBy('year')
                    ->orderBy('year');
            })
            ->get()
            ->map(function ($item) use ($weekly, $monthly, $yearly, $totalMembers) {
                if ($weekly) {
                    return [
                        'label' => $item->year . '-W' . str_pad($item->week, 2, '0', STR_PAD_LEFT),
                        'value' => ($item->present / $item->total) * 100
                    ];
                } elseif ($monthly) {
                    return [
                        'label' => $item->month,
                        'value' => ($item->present / $item->total) * 100
                    ];
                } elseif ($yearly) {
                    return [
                        'label' => $item->year,
                        'value' => ($item->present / $item->total) * 100
                    ];
                }
                return null;
            })
            ->filter()
            ->values();
    }
}
