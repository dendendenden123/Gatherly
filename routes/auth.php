<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/member', function () {
    return view('member.index');
})->name('member.index');

Route::get('/member/attendance', function () {
    return view("member.attendance");
});