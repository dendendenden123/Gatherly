<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Services\TaskService;
use App\Models\Task;
use App\Models\Role;
use Throwable;
use Auth;

class TaskController extends Controller
{
    protected TaskService $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    public function index(Request $request)
    {
        $tasks = $this->taskService->getFilteredTask($request);
        $totalTaskCount = Task::count();
        $pendingTaskCount = Task::where('status', 'pending')->count();
        $inProgressTaskCount = Task::where('status', 'in_progress')->count();
        $completedTaskCount = Task::where('status', 'completed')->count();
        $overdueTaskCount = Task::where('status', 'overdue')->count();
        $roleNames = Role::query()->pluck('name');

        if ($request->wantsJson()) {
            $taskList = view('admin.tasks.task-list', compact('tasks'))->render();
            return response()->json(['taskList' => $taskList]);
        }

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

    public function create()
    {
        $roleNames = Role::query()->pluck('name');
        return view('admin.tasks.create', compact('roleNames'));
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $taskCreatorId = Auth::id();

        Task::create([
            ...$validated,
            'task_creator_id' => $taskCreatorId
        ]);
        return redirect()->back()->with('success', 'Task created successfully!');
    }

    public function edit(Request $request, $taskId)
    {
        $roleNames = Role::query()->pluck('name');
        $task = Task::findOrFail($taskId)->first();
        return view('admin.tasks.edit', compact('roleNames', 'task'));
    }

    public function update(Request $request, $taskId)
    {
        dd('hello');
    }


    public function destroy(Request $request, $taskId)
    {
        try {
            Task::findOrFail($taskId)->delete();
            return back()->with(['success' => 'Task Deleted Successfully']);
        } catch (Throwable $e) {
            \Log::error('Failed to delete task id: ' . $taskId, ["error" => $e]);
            return back()->with(['error' => 'Task failed deleted']);
        }

    }
}
