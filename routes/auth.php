<?php
use App\Http\Controllers\EventController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\MemberAnnouncementController;
use App\Http\Controllers\MemberAttendanceController;
use App\Http\Controllers\MemberDashboardController;


Route::controller(MemberDashboardController::class)->group(function () {
    Route::get('/member', 'index')->name('member');
});

Route::get('/member/sermon', function () {
    return view("member.sermon");
});
Route::get('/member/tasks', function () {
    return view("member.tasks");
});

// Attendance Routes 
// authorize if the user is admin or minister and secretary (id 9)
Route::middleware(['Role:9'])->controller(AttendanceController::class)->group(function () {
    Route::get('/admin/attendance', 'index')->name('admin.attendance');
    Route::post('/admin/attendance/store', 'store')->name('admin.attendance.store');
    Route::get('/admin/attendance/create', 'create')->name('admin.attendance.create');
    Route::get('/admin/attendance/{id}', 'show')->name('admin.attendance.show');
});

Route::controller(AttendanceController::class)->group(function () {
    Route::get('/member/attendance', 'showMyAttendance')->name('my.attendance');
});

Route::controller(EventController::class)->group(function () {
    Route::get('/member/event', 'showMyEvents')->name('member.event');
});

Route::controller(NotificationController::class)->group(function () {
    Route::get('/member/notification', 'viewMyNotification')->name('member.notification');
});

Route::controller(TaskController::class)->group(function () {
    Route::get('/member/task', 'viewMytask')->name('member.task');
});



