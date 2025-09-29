<?php

namespace App\Observers;
use App\Models\User;
use App\Models\Task;
use App\Services\UserService;
use Throwable;

class UserObserver
{
    protected UserService $userService;
    public function __construct(UserService $userService, )
    {
        $this->userService = $userService;
    }
    public function created(User $user)
    {
        try {
            $userRoles = $this->userService->getUsersRoles($user->id);
            $userAssociation = $this->userService->getUserAssociation($user->id);
            $audiences = array_merge(['all', $userAssociation], $userRoles);
            $tasks = Task::whereIn('assignee', $audiences)->get();
            foreach ($tasks as $task) {
                $task->assignedUsers()->attach($user->id);
            }
        } catch (Throwable $e) {
            \Log::error('error asigning tasks to new user', ['error' => $e]);
        }
    }
}
