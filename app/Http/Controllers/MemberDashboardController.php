<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Services\UserService;

class MemberDashboardController extends Controller
{
    public function index()
    {
        return view('member.dashboard');
    }
}
