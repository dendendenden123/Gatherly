<?php

namespace App\Services;

use App\Models\User;
use Auth;
use Carbon\Carbon;
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

    //get the user association (KAPISANAN): binhi, kadiwa buklod
    public function getUserAssociation($userid)
    {
        try {
            $user = User::find($userid);
            if ($user && $user->birthdate) {
                $age = Carbon::parse($user->birthdate)->age;
                if ($age <= 17) {
                    return 'binhi';
                } elseif ($age >= 18 && $user->marital_status == 'married') {
                    return 'buklod';
                } else {
                    return 'kadiwa';
                }
            }
        } catch (\Throwable $e) {
            \log::error('failed to get user association', ['error' => $e]);
        }
    }

    public function getUsersRoles($userId)
    {
        try {
            $user = User::find($userId);
            if ($user && method_exists($user, 'officers')) {
                $officers = $user->officers()->with('role')->get();
                // If any officer record exists and role_id not equal to a placeholder (e.g., 100), consider as volunteer
                $isVolunteer = $officers->filter(function ($o) {
                    return isset($o->role_id) && (int) $o->role_id !== 100; // 100 appears to be a default placeholder
                })->isNotEmpty();
                if ($isVolunteer) {
                    $roles[] = 'volunteers';
                }

                // Add explicit role names to audience list (so notifications can target specific roles)
                foreach ($officers as $officer) {
                    if ($officer->relationLoaded('role') && $officer->role && !empty($officer->role->name)) {
                        $roles[] = $officer->role->name;
                    }
                }
            }

            return $roles;
        } catch (\Throwable $e) {
            \log::error('failed to get users role', ['error' => $e]);
        }
    }
}
