<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReportController;
use App\Models\Report;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;


Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/members', function () {
    return view('admin.members');
})->name('admin.members');

//Users Routes
Route::controller(ReportController::class)->group(function () {
    Route::get('/admin/reports/', 'index')->name('admin.reports');
    Route::get('/admin/reports/attendance-list', 'attendanceList')
        ->name('admin.reports.attendance.list');
    Route::get('/admin/reports/attendance-print', 'attendancePrint')
        ->name('admin.reports.attendance.print');
    Route::get('/admin/reports/attendance-export-csv', 'attendanceExportCsv')
        ->name('admin.reports.attendance.export.csv');
    Route::get('/admin/reports/attendance-export-excel', 'attendanceExportExcel')
        ->name('admin.reports.attendance.export.excel');
});

//Users Routes
Route::controller(UserController::class)->group(function () {
    Route::get('/admin/members/', 'index')->name('admin.members');
    Route::get('/admin/members/show/{id}/', 'show')->name('admin.members.show');
    Route::get('/admin/members/edit/{id}/', 'edit')->name('admin.members.edit');
    Route::put('/admin/members/update/', 'update')->name('admin.members.update');
    Route::put('/admin/members/{id}/status', 'updateStatus')->name('admin.members.updateStatus');
    Route::delete('/admin/members/destroy/{id}', 'destroy')->name('admin.members.destroy');
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
    Route::post('/admin/notifications', 'store')->name('admin.notifications.store');
    Route::post('/admin/notifications/mark-all-read', 'markAllRead')->name('admin.notifications.markAllRead');
    Route::post('/admin/notifications/{notification}/mark-read', 'markRead')->name('admin.notifications.markRead');
    Route::delete('/admin/notifications/{notification}', 'destroy')->name('admin.notifications.destroy');
    Route::delete('/admin/notifications', 'bulkDestroy')->name('admin.notifications.bulkDestroy');
});

//Officer Routes
Route::controller(OfficerController::class)->group(function () {
    Route::get('/admin/officers', 'index')->name('admin.officers');
    Route::post('/admin/officers/store', 'store')->name('admin.officers.store');
    Route::delete('/admin/officers/destroy/{id}', 'destroy')->name('admin.officers.destroy');
});

//Events Routes
Route::controller(EventController::class)->group(function () {
    Route::get('/admin/events', 'index')->name('admin.events.index');
    Route::get('/admin/events/create', 'create')->name('admin.events.create');
    Route::post('/admin/events/store', 'store')->name('admin.events.store');
    Route::delete('/admin/events/bulkDestroy', 'bulkDestroy')->name('admin.events.bulkDestroy');
    Route::delete('/admin/events/destroy/{id}', 'destroy')->name('admin.events.destroy');
    Route::get('/admin/events/show/{id}', 'show')->name('admin.events.show');
    Route::get('admin/events/edit/{id}', 'edit')->name('admin.events.edit');
    Route::put('admin/events/update/{id}', 'update')->name('admin.events.update');
});