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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event_occurrence()
    {
        return $this->belongsTo(EventOccurrence::class);
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

    public function scopeAggregatedChartData($query, $filters)
    {
        $from = Carbon::parse($filters['start_date'] ?? now()->subCentury());
        $to = Carbon::parse($filters['end_date'] ?? now());
        $eventId = $filters['event_id'] ?? null;
        $userId = $filters['userId'] ?? null;
        $status = $filters['status'] ?? null;
        $aggregate = $filters['aggregate'] ?? 'monthly';
        $weekly = Null;
        $monthly = Null;
        $yearly = Null;

        if ($aggregate === 'weekly') {
            $weekly = true;
        } else if ($aggregate === 'yearly') {
            $yearly = true;
        } else if ($aggregate === 'monthly') {
            $monthly = true;
        }

        return $query->with(['event_occurrence.event', 'user'])
            ->whereBetween('updated_at', [$from, $to])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($eventId, function ($query) use ($eventId) {
                $query->whereHas('event_occurrence.event', function ($q) use ($eventId) {
                    $q->where('id', $eventId);
                });
            })
            ->when($userId, function ($query) use ($userId) {
                $query->whereHas('user', function ($q) use ($userId) {
                    $q->where('id', $userId);
                });
            })
            ->when($weekly, function ($query) {
                $query->selectRaw("YEAR(updated_at) as year, WEEK(updated_at, 1) as week, COUNT(*) as total")
                    ->groupBy('year', 'week')
                    ->orderBy('year')
                    ->orderBy('week');
            })
            ->when($monthly, function ($query) {
                $query->selectRaw("DATE_FORMAT(updated_at, '%Y-%m') as month, COUNT(*) as total")
                    ->groupBy('month')
                    ->orderBy('month');
            })
            ->when($yearly, function ($query) {
                $query->selectRaw("YEAR(updated_at) as year, COUNT(*) as total")
                    ->groupBy('year')
                    ->orderBy('year');
            })
            ->get()
            ->map(function ($item) use ($weekly, $monthly, $yearly) {
                if ($weekly) {
                    return [
                        'label' => $item->year . '-W' . str_pad($item->week, 2, '0', STR_PAD_LEFT),
                        'value' => $item->total,
                    ];
                } elseif ($monthly) {
                    return [
                        'label' => $item->month,
                        'value' => $item->total,
                    ];
                } elseif ($yearly) {
                    return [
                        'label' => $item->year,
                        'value' => $item->total,
                    ];
                }
                return null;
            })
            ->filter()
            ->values();
    }
}
