<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $from = $filters['from'] ?? now()->subYear();
        $to = $filters['to'] ?? now();
        $userId = $filters['userId'] ?? null;
        $eventId = $filters['eventId'] ?? null;
        $searchByName = $filters['searchByName'] ?? null;
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
}
