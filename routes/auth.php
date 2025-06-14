<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/member/home', function () {
    return view('member.home');
})->name('member.home');
