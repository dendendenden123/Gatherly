<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Event;
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
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'attendances')
            ->using(Attendance::class)
            ->withPivot([
                'service_date',
                'check_in_time',
                'check_out_time',
                'attendance_method',
                'biometric_data_id',
                'recorded_by',
                'status',
                'notes',
            ])
            ->withTimestamps();
    }

    public function getAttendanceRate(): float
    {

        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        //Get the total number of worship service last month
        $monthlyWorshipSericeCount = $this->getDaysCount($startOfLastMonth, $endOfLastMonth);

        //Get the number of attended worship service last month
        $attendedService = $this->events()
            ->wherePivot('status', 'present')
            ->wherePivotBetween('service_date', [$startOfLastMonth, $endOfLastMonth])
            ->whereIn('event_type', ['weekdays worship service', 'Weekend worship service'])
            ->count();

        return intval(($attendedService / $monthlyWorshipSericeCount) * 100);

    }

    // Count the total number of Sundays and Thursdays within the specified date range
    public function getDaysCount($start, $end)
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
}
