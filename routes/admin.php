<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;


Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/attendance', function () {
    return view('admin.attendance');
})->name('admin.attendance');

Route::get('/admin/members', function () {
    return view('admin.members');
})->name('admin.members');

Route::get('/admin/reports', function () {
    return view('admin.reports');
})->name('admin.reports');

// Notification Routes
Route::controller(NotificationController::class)->group(function () {
    Route::get('/admin/notifications', 'index')->name('admin.notifications.index');
    Route::get('/admin/notifications/create', 'create')->name('admin.notifications.create');
});