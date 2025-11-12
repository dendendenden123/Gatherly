<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

class UserController extends Controller
{
    //===========================================
    //=== Password Reset Functionality
    //===========================================

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

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

        if ($request->ajax()) {
            $indexList = view('admin.members.index-list', compact('users'))->render();
            return response()->json(['list' => $indexList]);
        }
        return view('admin.members.index', compact('users'));
    }

    //===========================================
    //===Show information of specific member based on id
    //===========================================
    public function show($id)
    {
        $user = User::findOrFail($id)->first();
        return view('admin.members.show', compact('user'));
    }

    //===========================================
    //===Create new member info
    //===========================================
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'nullable|string|max:15',
                'address' => 'nullable|string|max:255',
                'district' => 'required|string|max:255',
                'locale' => 'required|string|max:255',
                'purok_grupo' => 'required|string|max:255',
                'birthdate' => 'required|date',
                'sex' => 'required|string|in:male,female',
                'baptism_date' => 'nullable|date',
                'marital_status' => 'required|string|in:single,married,separated,widowed,annulled',
                'document_image' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:4096',
            ], [
                'first_name.required' => 'Please enter your first name.',
                'first_name.max' => 'First name must not exceed 255 characters.',
                'last_name.required' => 'Please enter your last name.',
                'last_name.max' => 'Last name must not exceed 255 characters.',
                'middle_name.required' => 'Please enter your middle name.',
                'middle_name.max' => 'Middle name must not exceed 255 characters.',
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email address is already registered.',
                'password.required' => 'Please enter a password.',
                'password.min' => 'Password must be at least 8 characters long.',
                'password.confirmed' => 'Password confirmation does not match.',
                'phone.max' => 'Phone number must not exceed 15 characters.',
                'address.max' => 'Address must not exceed 255 characters.',
                'district.required' => 'Please enter your district.',
                'district.max' => 'District must not exceed 255 characters.',
                'locale.required' => 'Please enter your locale.',
                'locale.max' => 'Locale must not exceed 255 characters.',
                'purok_grupo.required' => 'Please enter your purok/grupo.',
                'purok_grupo.max' => 'Purok/Grupo must not exceed 255 characters.',
                'birthdate.required' => 'Please enter your birthdate.',
                'birthdate.date' => 'Please enter a valid birthdate.',
                'sex.required' => 'Please select your sex.',
                'sex.in' => 'Please select a valid sex option.',
                'baptism_date.date' => 'Please enter a valid baptism date.',
                'marital_status.required' => 'Please select your marital status.',
                'marital_status.in' => 'Please select a valid marital status.',
                'document_image.image' => 'Document must be an image file.',
                'document_image.mimes' => 'Document must be a JPG, JPEG, PNG, or PDF file.',
                'document_image.max' => 'Document file size must not exceed 4MB.',
            ]);

            // Handle file upload for document_image
            if ($request->hasFile('document_image')) {
                $path = $request->file('document_image')->store('documents', 'public');
                $validatedData['document_image'] = $path;
            }

            $user = User::create($validatedData);


            //logs action
            Log::create([
                'user_id' => null,
                'action' => 'create',
                'description' => 'New account was created. Account detail: ' . $user,
            ]);

            // Redirect to login with success message
            return redirect()->route('showLoginForm')->with('success', 'Registration successful! Please log in with your credentials.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return back with validation errors
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Registration failed: ' . $e->getMessage());

            // Return back with general error message
            return redirect()->back()->with('error', 'Registration failed. Please try again.')->withInput();
        }
    }

    //===========================================
    //===redirect to admin/members/edit page
    //===========================================
    public function edit($userId)
    {
        $user = User::with('officers')->findOrFail($userId)->first();
        return view('admin.members.edit', compact('user'));
    }

    //===========================================
    //===Update user's data
    //===========================================
    public function update(Request $request)
    {

        try {
            $validated = $request->validate([
                'id' => 'required|integer',
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'middle_name' => 'nullable|string|max:100',
                'email' => 'required|email|max:255  ',
                'password' => 'nullable|string|min:8|confirmed',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:100',
                'locale' => 'nullable|string|max:100',
                'purok_grupo' => 'nullable|string|max:100',
                'birthdate' => 'nullable|date',
                'sex' => 'nullable|in:male,female,other',
                'baptism_date' => 'nullable|date',
                'marital_status' => 'required|string|in:single,married,separated,widowed,annulled',
                'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'document_image' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:4096',
                'status' => 'nullable|in:active,inactive,suspended',
                'is_Verify' => 'boolean',
            ]);

            $user = User::findOrFail($validated['id']);

            //logs action
            Log::create([
                'user_id' => Auth::id(),
                'action' => 'update',
                'description' => 'Update user account. Account detail: ' . $user,
            ]);

            if ($request->hasFile('profile_image')) {
                if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                    Storage::disk('public')->delete($user->profile_image);
                }

                $path = $request->file('profile_image')->store('profiles', 'public');
                $validated['profile_image'] = $path;
            }

            if ($request->hasFile('document_image')) {
                if ($user->document_image && Storage::disk('public')->exists($user->document_image)) {
                    Storage::disk('public')->delete($user->document_image);
                }

                $path = $request->file('document_image')->store('profiles', 'public');
                $validated['document_image'] = $path;
            }


            $user->update($validated);
            return redirect()->back()->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            \Log::error('Updating user data failed: ' . $e->getMessage());
            return redirect()->back()->with('error', $e);
        }
    }

    //===========================================
    //===Quickly update user's status via AJAX
    //===========================================
    public function updateStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:active,inactive,partially-active,expelled',
            ]);

            $user = User::findOrFail($id);
            $user->status = $validated['status'];
            $user->save();

            //logs action
            Log::create([
                'user_id' => Auth::id(),
                'action' => 'update',
                'description' => 'Account status change. Account detail: ' . $user,
            ]);

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Quick status update failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update status'], 500);
        }
    }

    //===========================================
    //===Delete the specified user and redirect back to members list.
    //===========================================
    public function destroy($userId)
    {
        User::findOrFail($userId)->delete();

        //logs action
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'description' => 'Account deleted. Account Id: ' . $userId,
        ]);

        return redirect()->route('admin.members')->with(['success' => '']);
    }

    //===========================================
    //===Logs out the user, clears the session, and redirects to landing page
    //===For Google users, also logs out from Google
    //===========================================
    public function logout()
    {

        //logs action
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'logout',
            'description' => 'Account sign out',
        ]);

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
        logger($request->all());
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return redirect()->back()->with('error', 'Invalid Credentials');
        }

        $getUserid = auth()->id();
        $user = User::with('officers')->findOrFail($getUserid);

        //logs action
        Log::create([
            'user_id' => $user->id,
            'action' => 'login',
            'description' => 'Account logged in',
        ]);

        if ($user->officers->contains('role_id', '1')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('member');
    }

    public function viewForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function viewResetPassword()
    {
        return view('auth.reset-password');
    }

}
