<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\AttendanceController;


Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/members', function () {
    return view('admin.members');
})->name('admin.members');

Route::get('/admin/reports', function () {
    return view('admin.reports');
})->name('admin.reports');

//Users Routes
Route::controller(UserController::class)->group(function () {
    Route::get('/admin/members', 'index')->name('admin.members');
});


// Attendance Routes
Route::controller(AttendanceController::class)->group(function () {
    Route::get('/admin/attendance', 'index')->name('admin.attendance');
    Route::get('/admin/attendance/{id}', 'show')->name('admin.attendance.show');
});

// Notification Routes
Route::controller(NotificationController::class)->group(function () {
    Route::get('/admin/notifications', 'index')->name('admin.notifications.index');
    Route::get('/admin/notifications/create', 'create')->name('admin.notifications.create');
});

//Officer Routes
Route::controller(OfficerController::class)->group(function () {
    Route::get('/admin/officers', 'index')->name('admin.officers');
});

//Events Routes
Route::controller(EventController::class)->group(function () {
    Route::get('/admin/events', 'index')->name('admin.events.index');
    Route::get('/admin/events/create', 'create')->name('admin.events.create');
    Route::delete('/admin/events/destroy/{id}', 'destroy')->name('admin.events.destroy');
});

//Engagements Routes
Route::controller(EngagementController::class)->group(function () {
    Route::get('/admin/engagements', 'index')->name('admin.engagements.index');
});
