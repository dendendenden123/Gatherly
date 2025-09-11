<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Officer;

class UserTransformHelper
{
    /**
     * Transform user list with officer roles to JSON format.
     * 
     * @return string JSON encoded string
     */
    public static function transformUserListToJson($users): string
    {
        return $users->map(function ($user) {
            return [
                'id' => $user->id,
                'full_name' => self::getFullName($user),
                'roles' => $user->officers->map(function ($officer) {
                    return [
                        'role_id' => $officer->role->id,
                        'role_name' => $officer->role->name,
                    ];
                }),
            ];
        })->toJson();
    }

    /**
     * Get formatted full name from user object.
     * 
     * @param User $user
     * @return string
     */
    public static function getFullName(User $user): string
    {
        return trim("{$user->first_name} {$user->middle_name} {$user->last_name}");
    }

    /**
     * Transform user with officer roles to array format.
     * 
     * @param User $user
     * @return array
     */
    public static function transformUserToArray(User $user): array
    {
        return [
            'id' => $user->id,
            'full_name' => self::getFullName($user),
            'roles' => $user->officers->map(function ($officer) {
                return [
                    'role_id' => $officer->role->id,
                    'role_name' => $officer->role->name,
                ];
            })->toArray(),
        ];
    }

    public static function countTotalOfficers()
    {
        return Officer::count();
    }
}
