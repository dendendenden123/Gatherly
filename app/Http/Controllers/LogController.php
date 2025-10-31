<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LogService;
use App\Models\Role;

class LogController extends Controller
{
    protected LogService $logService;
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }
    public function index(Request $request)
    {
        $roleList = Role::select('id', 'name')->get();
        $logs = $this->logService->filterLogs($request);

        $logList = (clone $logs)->orderBy('created_at', 'desc')->simplePaginate(50);
        $totalLogs = (clone $logs)->count();
        $createCount = (clone $logs)->where('action', 'create')->count();
        $updateCount = (clone $logs)->where('action', 'update')->count();
        $deleteCount = (clone $logs)->where('action', 'delete')->count();


        return view('admin.logs.index', compact(
            'roleList',
            'logList',
            'totalLogs',
            'createCount',
            'updateCount',
            'deleteCount'

        ));
    }
}
