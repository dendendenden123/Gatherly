<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
})->name('landing_page');

// Authentication Routes
Route::controller(UserController::class)->group(function () {
    // Login/Logout
    Route::get('/login', 'showLoginForm')->name('showLoginForm');
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->name('logout');

    // Registration
    Route::get('/register', 'showRegisterForm')->name('showRegisterForm');
    Route::post('/register', 'store')->name('register');

    // Password Reset
    Route::get('/forgot-password', 'showForgotPasswordForm')->name('showForgotPassword');
    Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
    Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});

// Google OAuth routes
Route::controller(\App\Http\Controllers\GoogleAuthController::class)->group(function () {
    Route::get('/auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('/auth/google/callback', 'handleGoogleCallback')->name('auth.google.callback');
});