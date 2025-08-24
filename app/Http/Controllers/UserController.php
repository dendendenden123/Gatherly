<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //===========================================
    //===Display all members
    //===========================================
    public function index(Request $request)
    {
        $users = User::filter([
            'memberName' => $request->memberName,
            'role' => $request->role,
            'status' => $request->status,
            'sort' => $request->sort
        ])->simplePaginate(5);

        $totalMembersCount = User::query()->count();
        $volunteersMemberCount = User::whereHas('officers', function ($query) {
            $query->whereNot('role', '0');
        })->count();

        if ($request->ajax()) {
            $indexList = view('admin.members.index-list', compact('users', 'totalMembersCount', 'volunteersMemberCount'))->render();
            return response()->json(['list' => $indexList]);
        }
        return view('admin.members.index', compact('users', 'totalMembersCount', 'volunteersMemberCount'));
    }

    //===========================================
    //===Show information of specific member based on id
    //===========================================
    public function show($id)
    {
        return view('admin.members.show');
    }

    //===========================================
    //===Create new member info
    //===========================================
    public function store(Request $request)
    {
        // Validate the request data
        try {
            $validatedData = $request->validate([
                'role' => 'required|in:Minister,Finance,SCAN,Deacon,Kalihim,Choir,None',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'required|string|max:15',
                'sex' => 'required|string|in:male,female',
                'baptism_date' => 'required|date',
                'document_image' => 'required',
                'marital_status' => 'required|string',
                'address' => 'required|string|max:255',
                'birthdate' => 'required|date',
            ]);

            $user = User::create($validatedData);
            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    //===========================================
    //===Delete the specified user and redirect back to members list.
    //===========================================
    public function destroy($userId)
    {
        User::findOrFail($userId)->delete();
        return redirect()->route('admin.members')->with(['success' => '']);
    }

    //===========================================
    //===Logs out the user, clears the session, 
    //===regenerates the CSRF token, and redirects to landing page
    //===========================================
    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('landing_page');
    }

    //===========================================
    //===Redirect to Login Form
    //===========================================
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //===========================================
    //===Redirect to Register Form
    //===========================================
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    //===========================================
    //===Handles user login, validates credentials, 
    //===then redirects based on officer role (admin or member)
    //===========================================
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return redirect()->back()->with('error', 'Invalid Credentials');
        }

        $getUserid = auth()->id();
        $user = User::with('officers')->findOrFail($getUserid);
        if ($user->officers->contains('role', 1)) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('member.dashboard');
    }

}
