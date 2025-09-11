<?php

namespace App\Services;

use App\Models\Officer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OfficerService
{
    /**
     * Update officer roles for a user.
     * 
     * @param int $userId
     * @param array|null $roleIds
     * @return bool
     * @throws \Exception
     */
    public function updateUserRoles(int $userId, ?array $roleIds = []): bool
    {
        try {
            DB::transaction(function () use ($userId, $roleIds) {
                // Remove existing roles for the user
                Officer::where('user_id', $userId)->delete();

                // Add new roles
                foreach ($roleIds ?? [] as $roleId) {
                    Officer::create([
                        'user_id' => $userId,
                        'role_id' => $roleId,
                    ]);
                }
            });

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to update officer roles', [
                'user_id' => $userId,
                'role_ids' => $roleIds,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Remove all officer roles for a user.
     * 
     * @param int $userId
     * @return bool
     * @throws \Exception
     */
    public function removeUserRoles(int $userId): bool
    {
        try {
            Officer::where('user_id', $userId)->delete();
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to remove officer roles', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Get users with their officer roles.
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersWithOfficerRoles()
    {
        return \App\Models\User::whereHas('officers')
            ->with('officers.role')
            ->get();
    }

    /**
     * Get all available roles.
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableRoles()
    {
        return \App\Models\Role::select('name', 'id')->get();
    }
}
