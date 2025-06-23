<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/member', function () {
    return view('member.dashboard');
})->name('member.dashboard');

Route::get('/member/attendance', function () {
    return view("member.attendance");
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

