<?php

namespace App\Services;

use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function getAllUsers()
    {
        return User::with('officers.role')->get();
    }

    public function isUserAuthorize()
    {
        $userId = Auth::id();
        $loggedUser = User::with('officers')->find($userId);
        return ($loggedUser->officers->contains('role_id', 1) ||
            $loggedUser->officers->contains('role_id', 9));
    }
}
