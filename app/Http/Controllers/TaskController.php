<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Services\TaskService;
use App\Services\UserService;
use App\Models\Task;
use App\Models\Role;
use Throwable;
use Auth;

class TaskController extends Controller
{
    protected TaskService $taskService;
    protected UserService $userService;
    protected $userId;
    public function __construct(TaskService $taskService, UserService $userService)
    {
        $this->taskService = $taskService;
        $this->userService = $userService;
        $this->userId = Auth::id();
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
        Task::create([
            ...$validated,
            'task_creator_id' => $this->userId
        ]);
        return redirect()->back()->with('success', 'Task created successfully!');
    }

    public function edit(Request $request, $taskId)
    {
        $roleNames = Role::query()->pluck('name');
        $task = Task::findOrFail($taskId);
        return view('admin.tasks.edit', compact('roleNames', 'task'));
    }

    public function update(StoreTaskRequest $request, $taskId)
    {
        $validated = $request->validated();
        $task = Task::findOrFail($taskId);
        $taskCreatorId = Auth::id();

        $task->update([
            ...$validated,
            'task_creator_id' => $this->userId
        ]);
        return redirect()->back()->with('success', 'Task updated successfully!');
    }


    public function destroy($taskId)
    {
        try {
            Task::findOrFail($taskId)->delete();
            return back()->with(['success' => 'Task Deleted Successfully']);
        } catch (Throwable $e) {
            \Log::error('Failed to delete task id: ' . $taskId, ["error" => $e]);
            return back()->with(['error' => 'Task failed deleted']);
        }

    }

    public function viewMytask(Request $request)
    {
        $useAssoc = $this->userService->getUserAssociation($this->userId);
        $rawTask = $this->taskService->getUserTasks($this->userId, $useAssoc);
        $tasks = $rawTask->simplePaginate(5);
        $totalTaskCount = $rawTask->count();
        $pendingTaskCount = $rawTask->where('status', 'pending')->count();
        $inProgressTaskCount = $rawTask->where('status', 'in_progress')->count();
        $completedTaskCount = $rawTask->where('status', 'completed')->count();
        $overdueTaskCount = $rawTask->where('status', 'overdue')->count();
        $roleNames = Role::query()->pluck('name');

        if ($request->wantsJson()) {
            $taskList = view('admin.tasks.task-list', compact('tasks'))->render();
            return response()->json(['taskList' => $taskList]);
        }

        if ($request->ajax()) {
            $taskList = view('admin.tasks.task-list', compact('tasks'))->render();
            return response()->json(['list' => $taskList]);
        }

        return view('member.tasks', compact(
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
