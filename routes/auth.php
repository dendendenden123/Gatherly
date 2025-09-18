<?php

use App\Http\Controllers\MemberAttendanceController;
use App\Http\Controllers\MemberDashboardController;
use Illuminate\Support\Facades\Route;

Route::controller(MemberDashboardController::class)->group(function () {
    Route::get('/member', 'index')->name('member');
});

Route::controller(MemberAttendanceController::class)->group(function () {
    Route::get('/member/attendance', 'index')->name('attendance');
});

Route::get('/member/community-group', function () {
    return view("member.community-group");
});
Route::get('/member/announcement', function () {
    return view("member.announcement");
});
Route::get('/member/sermon', function () {
    return view("member.sermon");
});
Route::get('/member/messages', function () {
    return view("member.messages");
});
Route::get('/member/tasks', function () {
    return view("member.tasks");
});

