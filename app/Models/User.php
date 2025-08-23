<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Models\Attendance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthdate' => 'datetime'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function officers()
    {
        return $this->hasMany(Officer::class);
    }

    protected static function booted()
    {
        static::created(function ($user) {
            Officer::create([
                'user_id' => $user->id
            ]);
        });
    }

    public function getFullNameAttribute()
    {
        $names = array_filter([
            ucfirst($this->first_name),
            $this->middle_name ? ucfirst($this->middle_name) : null,
            ucfirst($this->last_name),
        ]);

        return implode(' ', $names);
    }

    public function getAttendanceRate(): float
    {
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        //Get the total number of worship service last month
        $monthlyWorshipSericeCount = $this->getDaysCount($startOfLastMonth, $endOfLastMonth);

        $attendedService = $this->attendances()
            ->where("status", "present")
            ->whereBetween('service_date', [$startOfLastMonth, $endOfLastMonth])
            ->whereHas('event_occurrence.event', function ($query) {
                $query->whereIn("event_type", [
                    "Weekend worship service",
                    "weekdays worship service"
                ]);
            })
            ->count();

        return intval(($attendedService / $monthlyWorshipSericeCount) * 100);
    }

    // Count the total number of Sundays and Thursdays within the specified date range
    private function getDaysCount($start, $end)
    {
        $period = CarbonPeriod::create($start, $end);
        $numberWorshipDays = 0;

        foreach ($period as $day) {
            if ($day->isSunday() || $day->isThursday()) {
                $numberWorshipDays++;
            }
        }

        return $numberWorshipDays;
    }

    //====================================
    //=== Filter users by full name, partial name, or ID (supports LIKE)
    //=== Optional: restrict by locale
    //====================================
    public function scopeFilter($query, $filter)
    {
        $nameOrId = $filter['memberName'] ?? null;
        $locale = $filter['locale'] ?? null;
        $role = $filter['role'] ?? null;
        $status = $filter['status'] ?? null;

        return $query->with('officers')
            ->when($nameOrId, function ($query) use ($nameOrId) {
                $query->where(function ($query) use ($nameOrId) {
                    $query->where(DB::raw("CONCAT(first_name, ' ', middle_name, ' ', last_name)"), 'like', "%{$nameOrId}%")
                        ->orWhere('first_name', 'like', "%{$nameOrId}%")
                        ->orWhere('middle_name', 'like', "%{$nameOrId}%")
                        ->orWhere('last_name', 'like', "%{$nameOrId}%")
                        ->orWhere('id', 'like', "%{$nameOrId}%");
                });
            })
            ->when($locale, function ($query) use ($locale) {
                $query->where('locale', $locale);
            })
            ->when($role, function ($query) use ($role) {
                $query->whereHas('officers', function ($q) use ($role) {
                    $q->where('role', $role);
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            });
    }

}
