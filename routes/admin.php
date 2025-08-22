<?php

use App\Http\Controllers\GuestController;
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
    Route::get('/admin/members/', 'index')->name('admin.members');
    Route::get('/admin/members/show/{id}', 'show')->name('admin.members.show');
});


// Attendance Routes
Route::controller(AttendanceController::class)->group(function () {
    Route::get('/admin/attendance', 'index')->name('admin.attendance');
    Route::post('/admin/attendance/store', 'store')->name('admin.attendance.store');
    Route::get('/admin/attendance/checkIn', 'checkIn')->name('admin.attendance.checkIn');
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
    Route::post('admin/events/store', 'store')->name('admin.events.store');
    Route::delete('/admin/events/bulkDestroy', 'bulkDestroy')->name('admin.events.bulkDestroy');
    Route::delete('/admin/events/destroy/{id}', 'destroy')->name('admin.events.destroy');
    Route::get('/admin/events/show/{id}', 'show')->name('admin.events.show');
    Route::get('admin/events/edit/{id}', 'edit')->name('admin.events.edit');
    Route::put('admin/events/update/{id}', 'update')->name('admin.events.update');
});

//Engagements Routes
Route::controller(EngagementController::class)->group(function () {
    Route::get('/admin/engagements', 'index')->name('admin.engagements.index');
});
