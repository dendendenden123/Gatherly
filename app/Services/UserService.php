<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function getAllUsers()
    {
        return User::with('officers.role')->get();
    }
}
