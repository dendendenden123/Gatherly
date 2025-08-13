<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()->orderByDesc('updated_at')->simplePaginate(5);

        return view('admin.members', compact('users'));
    }
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

            // Create a new user
            $user = User::create($validatedData);

            // Return a response
            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function logout()
    {
        auth()->logout();
        // Invalidate the session
        request()->session()->invalidate();
        // Regenerate CSRF token
        request()->session()->regenerateToken();
        return redirect()->route('landing_page');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }

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
