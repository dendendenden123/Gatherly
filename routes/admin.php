<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/attendance', function () {
    return view('admin.attendance');
})->name('admin.attendance');

Route::get('/admin/members', function () {
    return view('admin.members');
})->name('admin.members');