<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                // User exists, log them in
                Auth::login($existingUser);

                // Redirect based on role
                return $this->redirectBasedOnRole($existingUser);
            } else {
                // Create new user
                $newUser = User::create([
                    'first_name' => $this->extractFirstName($googleUser->getName()),
                    'last_name' => $this->extractLastName($googleUser->getName()),
                    'middle_name' => '', // Google doesn't provide middle name
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)), // Random password since they'll use Google
                    'google_id' => $googleUser->getId(),
                    'profile_image' => $googleUser->getAvatar(),
                    'is_google_user' => true,
                    'status' => 'active',
                    'is_Verify' => true, // Google users are considered verified
                    // Set default values for required fields
                    'district' => 'Not specified',
                    'locale' => 'Not specified',
                    'purok_grupo' => 'Not specified',
                    'birthdate' => '1990-01-01', // Default birthdate
                    'sex' => 'male', // Default sex
                    'marital_status' => 'single', // Default marital status
                ]);

                Auth::login($newUser);

                // Redirect based on role
                return $this->redirectBasedOnRole($newUser);
            }

        } catch (\Exception $e) {
            \Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect()->route('showLoginForm')->with('error', 'Login with Google failed. Please try again.');
        }
    }

    /**
     * Extract first name from full name
     */
    private function extractFirstName($fullName)
    {
        $nameParts = explode(' ', trim($fullName));
        return $nameParts[0] ?? 'User';
    }

    /**
     * Extract last name from full name
     */
    private function extractLastName($fullName)
    {
        $nameParts = explode(' ', trim($fullName));
        return count($nameParts) > 1 ? end($nameParts) : 'User';
    }

    /**
     * Redirect user based on their role
     */
    private function redirectBasedOnRole($user)
    {
        $user->load('officers');

        if ($user->officers->contains('role_id', '1')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('member');
    }
}
