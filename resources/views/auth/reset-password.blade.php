<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .password-strength {
            height: 4px;
            transition: all 0.3s ease;
        }

        .strength-0 {
            width: 0%;
            background-color: #ef4444;
        }

        .strength-1 {
            width: 25%;
            background-color: #ef4444;
        }

        .strength-2 {
            width: 50%;
            background-color: #f59e0b;
        }

        .strength-3 {
            width: 75%;
            background-color: #eab308;
        }

        .strength-4 {
            width: 100%;
            background-color: #22c55e;
        }
    </style>
</head>

<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Reset Password
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Enter the verification code sent to your email and set a new password.
                </p>
            </div>
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Email address">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="sr-only">New Password</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="New Password">
                        <div class="mt-2">
                            <div class="password-strength strength-0" id="password-strength"></div>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <ul id="password-requirements" class="mt-2 text-xs text-gray-500 space-y-1 hidden">
                            <li id="req-length" class="flex items-center"><span class="mr-1">•</span> At least 8
                                characters</li>
                            <li id="req-uppercase" class="flex items-center"><span class="mr-1">•</span> One uppercase
                                letter</li>
                            <li id="req-lowercase" class="flex items-center"><span class="mr-1">•</span> One lowercase
                                letter</li>
                            <li id="req-number" class="flex items-center"><span class="mr-1">•</span> One number</li>
                            <li id="req-special" class="flex items-center"><span class="mr-1">•</span> One special
                                character</li>
                        </ul>
                    </div>
                    <div>
                        <label for="password_confirmation" class="sr-only">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Confirm New Password">
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Reset Password
                    </button>
                </div>
            </form>

            <div class="text-sm text-center mt-4">
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Back to Login
                </a>
            </div>
            <!-- Success message (initially hidden) -->
            <div id="success-message" class="hidden mt-4 p-4 bg-green-50 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            Password reset successfully! You can now log in with your new password.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordStrength = document.getElementById('password-strength');
            const passwordRequirements = document.getElementById('password-requirements');
            const requirements = {
                length: document.getElementById('req-length'),
                uppercase: document.getElementById('req-uppercase'),
                lowercase: document.getElementById('req-lowercase'),
                number: document.getElementById('req-number'),
                special: document.getElementById('req-special')
            };

            // Show password requirements on focus
            passwordInput.addEventListener('focus', function() {
                passwordRequirements.classList.remove('hidden');
            });

            // Hide password requirements when clicking outside
            document.addEventListener('click', function(e) {
                if (e.target !== passwordInput) {
                    passwordRequirements.classList.add('hidden');
                }
            });

            // Check password strength
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;

                // Check length
                if (password.length >= 8) {
                    strength++;
                    requirements.length.classList.add('text-green-500');
                    requirements.length.classList.remove('text-gray-500');
                } else {
                    requirements.length.classList.remove('text-green-500');
                    requirements.length.classList.add('text-gray-500');
                }

                // Check uppercase
                if (/[A-Z]/.test(password)) {
                    strength++;
                    requirements.uppercase.classList.add('text-green-500');
                    requirements.uppercase.classList.remove('text-gray-500');
                } else {
                    requirements.uppercase.classList.remove('text-green-500');
                    requirements.uppercase.classList.add('text-gray-500');
                }

                // Check lowercase
                if (/[a-z]/.test(password)) {
                    strength++;
                    requirements.lowercase.classList.add('text-green-500');
                    requirements.lowercase.classList.remove('text-gray-500');
                } else {
                    requirements.lowercase.classList.remove('text-green-500');
                    requirements.lowercase.classList.add('text-gray-500');
                }

                // Check number
                if (/\d/.test(password)) {
                    strength++;
                    requirements.number.classList.add('text-green-500');
                    requirements.number.classList.remove('text-gray-500');
                } else {
                    requirements.number.classList.remove('text-green-500');
                    requirements.number.classList.add('text-gray-500');
                }

                // Check special character
                if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                    strength++;
                    requirements.special.classList.add('text-green-500');
                    requirements.special.classList.remove('text-gray-500');
                } else {
                    requirements.special.classList.remove('text-green-500');
                    requirements.special.classList.add('text-gray-500');
                }

                // Update strength meter
                passwordStrength.className = 'password-strength';
                passwordStrength.classList.add(`strength-${strength}`);
            });
        });

        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;

            // Length check
            if (password.length >= 8) {
                strength++;
                document.getElementById('req-length').classList.add('text-green-500');
            } else {
                document.getElementById('req-length').classList.remove('text-green-500');
            }

            // Uppercase check
            if (/[A-Z]/.test(password)) {
                strength++;
                document.getElementById('req-uppercase').classList.add('text-green-500');
            } else {
                document.getElementById('req-uppercase').classList.remove('text-green-500');
            }

            // Lowercase check
            if (/[a-z]/.test(password)) {
                strength++;
                document.getElementById('req-lowercase').classList.add('text-green-500');
            } else {
                document.getElementById('req-lowercase').classList.remove('text-green-500');
            }

            // Number check
            if (/[0-9]/.test(password)) {
                strength++;
                document.getElementById('req-number').classList.add('text-green-500');
            } else {
                document.getElementById('req-number').classList.remove('text-green-500');
            }

            // Special character check
            if (/[^A-Za-z0-9]/.test(password)) {
                strength++;
                document.getElementById('req-special').classList.add('text-green-500');
            } else {
                document.getElementById('req-special').classList.remove('text-green-500');
            }

            // Update strength meter
            document.getElementById('password-strength').className = `password-strength strength-${strength}`;

            return strength;
        }

        // Add event listeners for real-time validation
        document.getElementById('password').addEventListener('input', function () {
            const password = this.value;
            document.getElementById('password-requirements').classList.remove('hidden');
            checkPasswordStrength(password);
        });

        document.getElementById('password_confirmation').addEventListener('input', function () {
            const password = document.getElementById('password').value;
            const passwordConfirm = this.value;
            const passwordConfirmError = document.getElementById('password-confirm-error');

            if (password !== passwordConfirm && passwordConfirm.length > 0) {
                passwordConfirmError.textContent = 'Passwords do not match.';
                passwordConfirmError.classList.remove('hidden');
            } else {
                passwordConfirmError.classList.add('hidden');
            }
        });
    </script>
</body>

</html>