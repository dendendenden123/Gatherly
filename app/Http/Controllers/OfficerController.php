<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficerRequest;
use App\Helpers\UserTransformHelper;
use App\Helpers\OfficerHelper;
use App\Services\OfficerService;
use App\Services\UserService;


class OfficerController extends Controller
{
    protected OfficerService $officerService;
    protected UserService $userService;
    public function __construct(OfficerService $officerService, UserService $userService)
    {
        $this->officerService = $officerService;
        $this->userService = $userService;
        $this->usersCollection = $this->userService->getAllUsers();
    }

    public function index()
    {
        $usersCollection = $this->userService->getAllUsers();
        $formattedUser = UserTransformHelper::transformUserListToJson($usersCollection);
        $roles = $this->officerService->getAvailableRoles();
        $officers = $this->officerService->getUsersWithOfficerRoles();
        $totalOfficers = OfficerHelper::countTotalOfficer($officers);
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

            return back()->with('success', 'Roles updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update roles. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->officerService->removeUserRoles($id);
            return back()->with('success', 'Roles deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete roles. Please try again.');
        }
    }

}
