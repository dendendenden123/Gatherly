<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Observers\TaskObserver;
use App\Observers\UserObserver;
use App\Observers\AttendanceObserver;
use Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use App\Http\Middleware\AuthAdmin;
use App\Models\User;
use App\Models\Task;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Route::middleware(['web', 'auth'])
            ->group(base_path('routes/auth.php'));

        Route::middleware(['web', 'auth', AuthAdmin::class])
            ->group(base_path('routes/admin.php'));

        Blade::if('secretary', function () {
            $userId = Auth::id();
            $loggedUser = User::with('officers')->find($userId);
            return ($loggedUser->officers->contains('role_id', 1) ||
                $loggedUser->officers->contains('role_id', 9));
        });

        Blade::if('admin', function () {
            $userId = Auth::id();
            $loggedUser = User::with('officers')->find($userId);
            return ($loggedUser->officers->contains('role_id', 1));
        });

        Blade::if('member', function () {
            $userId = Auth::id();
            $loggedUser = User::with('officers')->find($userId);
            return !($loggedUser->officers->contains('role_id', 1));
        });

        Task::observe(TaskObserver::class);
        User::observe(UserObserver::class);
        Attendance::observe(AttendanceObserver::class);
    }
}
