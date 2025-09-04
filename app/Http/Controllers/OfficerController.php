<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    public function index()
    {
        $users = User::whereHas('officers')->with('officers')->get();
        return view('admin.officers.index', compact('users'));
    }

    public function store(Request $request)
    {
        logger($request->all());
    }
}
