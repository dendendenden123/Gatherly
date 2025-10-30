<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        logger($request->all());
        return view('admin.logs.index');
    }
}
