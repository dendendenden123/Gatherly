<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthAdmin;

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

        Route::middleware(['web', AuthAdmin::class])
            ->group(base_path('routes/admin.php'));
    }
}
