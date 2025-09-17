# Google OAuth Setup Instructions

## 1. Google Cloud Console Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google+ API
4. Go to "Credentials" in the left sidebar
5. Click "Create Credentials" → "OAuth 2.0 Client IDs"
6. Choose "Web application"
7. Add authorized redirect URIs:
    - For development: `http://localhost:8000/auth/google/callback`
    - For production: `https://yourdomain.com/auth/google/callback`

## 2. Environment Configuration

Add these variables to your `.env` file:

```env
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

## 3. Features Implemented

-   ✅ Google OAuth login and registration
-   ✅ Automatic user creation for new Google users
-   ✅ Existing user login with Google
-   ✅ Role-based redirection (admin/member)
-   ✅ Beautiful Google sign-in buttons
-   ✅ Error handling and validation

## 4. How It Works

1. User clicks "Continue with Google" or "Sign up with Google"
2. Redirects to Google OAuth consent screen
3. User authorizes the application
4. Google redirects back with user data
5. System checks if user exists:
    - If exists: Log them in
    - If new: Create account with Google data
6. Redirect to appropriate dashboard based on role

## 5. Database Changes

The following fields were added to the `users` table:

-   `google_id` (string, nullable, unique)
-   `is_google_user` (boolean, default false)

## 6. Security Notes

-   Google users are automatically verified (`is_Verify = true`)
-   Random passwords are generated for Google users
-   Profile images are stored from Google
-   Default values are set for required fields not provided by Google
