<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Jobs\RecordAbsentAttendance;
use App\Models\Event;

Route::get('/ira', function () {
    view('ira');
});

Route::get('/', function () {
    return view('welcome');
})->name('landing_page');

Route::controller(UserController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('showLoginForm');
    Route::post('/login', 'login')->name('login');
    Route::get('/register', 'showRegisterForm')->name('showRegisterForm');
    Route::post('/register', 'store')->name('register');
    Route::get('/logout', 'logout')->name('logout');
});

// Google OAuth routes
Route::controller(\App\Http\Controllers\GoogleAuthController::class)->group(function () {
    Route::get('/auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('/auth/google/callback', 'handleGoogleCallback')->name('auth.google.callback');
});