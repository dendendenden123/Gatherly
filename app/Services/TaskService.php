<?php

namespace App\Services;

use App\Models\Task;
class TaskService
{
    public function getFilteredTask($request)
    {
        $status = $request->input('status') == '*' ? null : $request->input('status');
        $priority = $request->input('priority') == '*' ? null : $request->input('priority');
        $category = $request->input('category') == '*' ? null : $request->input('category');

        return Task::query()
            ->when($status, fn($task) => $task->where('status', $status))
            ->when($priority, fn($task) => $task->where('priority', $priority))
            ->when($category, fn($task) => $task->where('assignee', $category))
            ->orderByDesc('id')
            ->simplePaginate(5);
    }
}