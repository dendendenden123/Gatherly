<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Services\TaskService;
use App\Services\UserService;
use App\Models\Task;
use App\Models\Role;
use App\Models\User;
use App\Models\Log;
use Throwable;
use DB;
use Auth;

class TaskController extends Controller
{
    protected TaskService $taskService;
    protected UserService $userService;
    protected $roleNames;
    protected $userId;
    protected $user;
    public function __construct(TaskService $taskService, UserService $userService)
    {
        $this->taskService = $taskService;
        $this->userService = $userService;
        $this->userId = Auth::id();
        $this->user = User::find($this->userId);
        $this->roleNames = Role::query()->pluck('name');

    }
    public function index(Request $request)
    {

        $taskUserTable = DB::table('task_user');
        $tasks = $this->taskService->getFilteredTask($request);
        $totalTaskCount = Task::count();
        $distributedTaskCount = (clone $taskUserTable)->count();
        $pendingTaskCount = (clone $taskUserTable)->where('status', 'pending')->count();
        $inProgressTaskCount = (clone $taskUserTable)->where('status', 'in_progress')->count();
        $completedTaskCount = (clone $taskUserTable)->where('status', 'completed')->count();
        $overdueTaskCount = (clone $taskUserTable)->where('status', 'overdue')->count();
        $roleNames = $this->roleNames;

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
            'distributedTaskCount',
            'pendingTaskCount',
            'inProgressTaskCount',
            'completedTaskCount',
            'overdueTaskCount',
            'roleNames'
        ));
    }

    public function create()
    {
        $roleNames = $this->roleNames;
        return view('admin.tasks.create', compact('roleNames'));
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $task = Task::create([
            ...$validated,
            'task_creator_id' => $this->userId
        ]);

        //logs action
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'description' => 'Create new task. Task detail: ' . $task,
        ]);

        return redirect()->back()->with('success', 'Task created successfully!');
    }

    public function show($taskId)
    {
        $task = Task::with(['user', 'assignedUsers'])->findOrFail($taskId);

        // Get assigned users with their pivot data
        $assignedUsers = $task->assignedUsers()->withPivot('status', 'comment', 'created_at', 'updated_at')->get();

        // Count statistics
        $totalAssigned = $assignedUsers->count();
        $pendingCount = $assignedUsers->where('pivot.status', 'pending')->count();
        $inProgressCount = $assignedUsers->where('pivot.status', 'in_progress')->count();
        $completedCount = $assignedUsers->where('pivot.status', 'completed')->count();
        $overdueCount = $assignedUsers->where('pivot.status', 'overdue')->count();

        return view('admin.tasks.show', compact(
            'task',
            'assignedUsers',
            'totalAssigned',
            'pendingCount',
            'inProgressCount',
            'completedCount',
            'overdueCount'
        ));
    }

    public function edit(Request $request, $taskId)
    {
        $roleNames = $this->roleNames;
        $task = Task::findOrFail($taskId);
        return view('admin.tasks.edit', compact('roleNames', 'task'));
    }

    public function update(StoreTaskRequest $request, $taskId)
    {
        $validated = $request->validated();
        $task = Task::findOrFail($taskId);
        $taskCreatorId = Auth::id();

        $task = $task->update([
            ...$validated,
            'task_creator_id' => $this->userId
        ]);

        //logs action
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'update',
            'description' => 'Update a task. Task detail: ' . $task,
        ]);

        return redirect()->back()->with('success', 'Task updated successfully!');
    }


    public function destroy($taskId)
    {
        try {
            $task = Task::findOrFail($taskId)->delete();

            //logs action
            Log::create([
                'user_id' => Auth::id(),
                'action' => 'delete',
                'description' => 'deleted a task. Task detail: ' . $task,
            ]);

            return back()->with(['success' => 'Task Deleted Successfully']);
        } catch (Throwable $e) {
            \Log::error('Failed to delete task id: ' . $taskId, ["error" => $e]);
            return back()->with(['error' => 'Task failed deleted']);
        }

    }

    public function viewMytask(Request $request)
    {
        $assignedTask = $this->user->assignedTasks();
        $tasks = $this->taskService->getFilteredTask($request, (clone $assignedTask));
        $totalTaskCount = (clone $assignedTask)->count();
        $pendingTaskCount = (clone $assignedTask)->wherePivot('status', 'pending')->count();
        $inProgressTaskCount = (clone $assignedTask)->wherePivot('status', 'in_progress')->count();
        $completedTaskCount = (clone $assignedTask)->wherePivot('status', 'completed')->count();
        $overdueTaskCount = (clone $assignedTask)->wherePivot('status', 'overdue')->count();
        $roleNames = $this->roleNames;

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

    public function updateTaskStatus(Request $request, $taskId)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,in_progress,completed',
                'comment' => 'nullable|string|max:1000',
            ]);

            $userId = Auth::id();

            // Update the pivot table
            $user = User::find($userId);
            $user->assignedTasks()->updateExistingPivot($taskId, [
                'status' => $validated['status'],
                'comment' => $validated['comment'],
            ]);

            // Log the action
            Log::create([
                'user_id' => $userId,
                'action' => 'update',
                'description' => "Updated task status to {$validated['status']} for task ID: {$taskId}",
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully!'
            ]);

        } catch (\Throwable $e) {
            \Log::error('Failed to update task status', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task'
            ], 500);
        }
    }
}
