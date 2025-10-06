<?php

namespace App\Observers;

use App\Services\UserService;
use App\Models\Task;
use App\Models\User;
use Throwable;

class TaskObserver
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function created(Task $task)
    {
        try {
            $users = User::all();

            $matchingUserIds = $users->filter(function ($user) use ($task) {
                $userRoles = $this->userService->getUsersRoles($user->id);
                $userAssociation = $this->userService->getUserAssociation($user->id);
                $audiences = array_merge(['all', $userAssociation], $userRoles);

                return in_array($task->assignee, $audiences);
            })->pluck('id')->toArray();

            if (!empty($matchingUserIds)) {
                $task->assignedUsers()->attach($matchingUserIds);
            }
        } catch (Throwable $e) {
            \Log::error('Error storing data into task_user table', ['error' => $e]);
        }

    }
}
