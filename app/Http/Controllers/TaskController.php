<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Role;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        logger('task', $request->all());
        $tasks = Task::query()->orderByDesc('id')->simplePaginate(5);
        $totalTaskCount = Task::count();
        $pendingTaskCount = Task::where('status', 'pending')->count();
        $inProgressTaskCount = Task::where('status', 'in_progress')->count();
        $completedTaskCount = Task::where('status', 'completed')->count();
        $overdueTaskCount = Task::where('status', 'overdue')->count();
        $roleNames = Role::query()->pluck('name');

        if ($request->ajax()) {
            $taskList = view('admin.tasks.task-list', compact('tasks'))->render();
            return response()->json(['list' => $taskList]);
        }
        return view('admin.tasks.index', compact(
            'tasks',
            'totalTaskCount',
            'pendingTaskCount',
            'inProgressTaskCount',
            'completedTaskCount',
            'overdueTaskCount',
            'roleNames'
        ));
    }
}
