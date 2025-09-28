<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'created_at' => 'date',
        'password' => 'hashed',
        'birthdate' => 'date'
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

    //====================================
    //=== Get the attendances for the user
    //====================================
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    //====================================
    //=== Get the officers for the user
    //====================================
    public function officers()
    {
        return $this->hasMany(Officer::class);
    }

    public function notfications()
    {
        return $this->HasMany(Notification::class);
    }

    public function sermons()
    {
        return $this->hasMany(Sermon::class);
    }

    public function receivedNotifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_user')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function assignedTasks()
    {
        return $this->belongsToMany(Task::class)->withPivot('status', 'comment')
            ->withTimestamps();
    }

    //====================================
    //=== Create an officer record for the user when the user is created
    //====================================
    protected static function booted()
    {
        static::created(function ($user) {
            Officer::create([
                'user_id' => $user->id,
                'role_id' => 100,
            ]);
        });
    }

    //====================================
    //=== Get the full name of the user
    //====================================
    public function getFullNameAttribute()
    {
        $names = array_filter([
            ucfirst($this->first_name),
            $this->middle_name ? ucfirst($this->middle_name) : null,
            ucfirst($this->last_name),
        ]);

        return implode(' ', $names);
    }

    //====================================
    //=== Count the total number of Sundays and Thursdays within the specified date range
    //====================================
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
        $sort = $filter['sort'] ?? null;

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
                    $q->where('role_id', $role);
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($sort, function ($query) use ($sort) {
                if ($sort == 'latest') {
                    $query->orderBy('created_at');
                } else if ($sort == 'alphabetAsc') {
                    $query->orderBy('first_name')
                        ->orderBy('middle_name')
                        ->orderBy('last_name');
                } else if ($sort == 'alphabetDesc') {
                    $query->orderBy('first_name', 'desc')
                        ->orderBy('middle_name', 'desc')
                        ->orderBy('last_name', 'desc');
                } else if ($sort == 'locale') {
                    $query->orderBy('locale');
                }
            });
    }
}
