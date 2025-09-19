<?php

use App\Http\Controllers\MemberAnnouncementController;
use App\Http\Controllers\MemberAttendanceController;
use App\Http\Controllers\MemberDashboardController;
use Illuminate\Support\Facades\Route;

Route::controller(MemberDashboardController::class)->group(function () {
    Route::get('/member', 'index')->name('member');
});

Route::controller(MemberAnnouncementController::class)->group(function () {
    Route::get('/member/announcement', 'index')->name('announcement');
});

Route::get('/member/sermon', function () {
    return view("member.sermon");
});
Route::get('/member/tasks', function () {
    return view("member.tasks");
});


Route::controller(MemberAttendanceController::class)->group(function () {
    Route::get('/member/my-attendance', 'showMyAttendance')->name('my.attendance');
    Route::get('/member/officer/attendance', 'index')->name('member.attendance.index');
});

