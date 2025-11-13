<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Services\UserService;
use Auth;
class TaskService
{
    protected UserService $userService;
    protected $userId;
    protected $user;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->userId = Auth::id();
        $this->user = User::find($this->userId);
    }

    public function getFilteredTask($request, $task = null)
    {
        $status = $request->input('status') == '*' ? null : $request->input('status');
        $priority = $request->input('priority') == '*' ? null : $request->input('priority');
        $category = $request->input('category') == '*' ? null : $request->input('category');

        $task = $task ?? Task::with(['user:id,first_name,middle_name,last_name']);

        // Check if we're filtering a BelongsToMany relationship (for member tasks)
        $isPivotQuery = $task instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany;

        return $task
            ->when($status && $isPivotQuery, fn($task) => $task->wherePivot('status', $status))
            ->when($status && !$isPivotQuery, fn($task) => $task->where('status', $status))
            ->when($priority, fn($task) => $task->where('priority', $priority))
            ->when($category, fn($task) => $task->where('assignee', $category))
            ->orderByDesc('id')
            ->simplePaginate(5);
    }

    public function getUserTasks($userId, $userAssociation = null)
    {
        $userRoles = $this->userService->getUsersRoles($userId);
        $audiences = array_merge(['all', $userAssociation], $userRoles);

        return Task::when(!empty($audiences), function ($q) use ($audiences) {
            $q->whereIn('assignee', $audiences);
        });
    }
}