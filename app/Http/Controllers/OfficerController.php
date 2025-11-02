<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\StoreOfficerRequest;
use App\Helpers\UserTransformHelper;
use App\Helpers\OfficerHelper;
use App\Services\OfficerService;
use App\Services\UserService;
use App\Models\Log;

class OfficerController extends Controller
{
    protected OfficerService $officerService;
    protected UserService $userService;
    public function __construct(OfficerService $officerService, UserService $userService)
    {
        $this->officerService = $officerService;
        $this->userService = $userService;
    }

    public function index()
    {
        $usersCollection = $this->userService->getAllUsers();
        $formattedUser = UserTransformHelper::transformUserListToJson($usersCollection);
        $roles = $this->officerService->getAvailableRoles();
        
        $filters = [
            'role' => request('role'),
            'search' => request('search'),
            'start_date' => request('start_date'),
            'end_date' => request('end_date')
        ];
        
        $officers = $this->officerService->getUsersWithOfficerRoles($filters);
        $totalOfficers = OfficerHelper::countTotalOfficer($officers);
        
        if (request()->ajax()) {
            return view('admin.officers.index-officers-list', compact('officers'))->render();
        }
        
        return view('admin.officers.index', compact('officers', 'totalOfficers', 'formattedUser', 'roles'));
    }

    public function store(StoreOfficerRequest $request)
    {
        try {
            $validated = $request->validated();

            $this->officerService->updateUserRoles(
                $validated['user_id'],
                $validated['roles'] ?? []
            );

            //logs action
            Log::create([
                'user_id' => Auth::id(),
                'action' => 'create',
                'description' => 'Assign new roles. Detail: user_id: ' . $validated['user_id'] . ', roles: ' . implode(', ', $validated['roles'])
            ]);

            return back()->with('success', 'Roles updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update roles. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->officerService->removeUserRoles($id);

            //logs action
            Log::create([
                'user_id' => Auth::id(),
                'action' => 'delete',
                'description' => 'Remove roles for users. User Id: ' . $id,
            ]);
            return back()->with('success', 'Roles deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete roles. Please try again.');
        }
    }

}
