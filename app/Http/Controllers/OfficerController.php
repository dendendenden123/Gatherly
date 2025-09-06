<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    public function index()
    {
        // $userList = User::select('id', 'first_name', 'last_name')->get()->toJson();
        $userList = User::with('officers')->get()->toJson();
        $users = User::whereHas('officers')->with('officers')->get();
        return view('admin.officers.index', compact('users', 'userList'));
    }

    public function store(Request $request)
    {
        logger($request->all());
    }
}
