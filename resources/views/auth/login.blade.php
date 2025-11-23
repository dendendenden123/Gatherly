<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #2ecc71;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            min-height: 600px;
        }

        .illustration {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: top;
            padding: 40px;
            color: black;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .illustration::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            top: -100px;
            right: -100px;
        }

        .illustration::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            bottom: -80px;
            left: -80px;
        }

        .illustration h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 600;
            z-index: 1;
        }

        .illustration p {
            font-size: 16px;
            opacity: 0.9;
            max-width: 300px;
            z-index: 1;
        }

        .illustration-img {
            width: 80%;
            max-width: 300px;
            margin: 30px 0;
            z-index: 1;
        }

        .form-container {
            background: gray;
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Add shadow */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            /* optional: rounded corners for nicer effect */
            background-color: rgba(128, 128, 128, 0.05);
            /* gray with 30% opacity */
            /* make sure shadow is visible on non-white backgrounds */
        }

        .form-toggle {
            display: flex;
            margin-bottom: 30px;
            border-radius: 10px;
            background: #f3f4f6;
            padding: 5px;
            position: relative;
        }

        .toggle-btn {
            flex: 1;
            padding: 12px;
            text-align: center;
            background: transparent;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1;
        }

        .toggle-slider {
            position: absolute;
            top: 5px;
            left: 5px;
            width: calc(50% - 5px);
            height: calc(100% - 10px);
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .toggle-slider.login {
            left: 5px;
        }

        .toggle-slider.register {
            left: calc(50%);
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-title {
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #2ecc71;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .alert i {
            margin-right: 10px;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            padding: 0 15px;
            color: #6b7280;
            font-size: 14px;
        }

        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: white;
            color: #374151;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .google-btn:hover {
            background: #f9fafb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: #2ecc71;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: #4338ca;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .form-footer {
            text-align: center;
            margin-top: 25px;
            color: #6b7280;
            font-size: 14px;
        }

        .auth-link {
            color: #2ecc71;
            text-decoration: none;
            font-weight: 500;
            margin-left: 5px;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        .additional-fields {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease;
        }

        .additional-fields.show {
            max-height: 1000px;
        }

        .toggle-fields {
            display: flex;
            align-items: center;
            color: #2ecc71;
            font-size: 14px;
            font-weight: 500;
            background: none;
            border: none;
            cursor: pointer;
            margin-bottom: 15px;
        }

        .toggle-fields i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .toggle-fields.rotate i {
            transform: rotate(180deg);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                max-width: 500px;
            }

            .illustration {
                padding: 30px 20px;
            }

            .illustration h2 {
                font-size: 24px;
            }

            .illustration p {
                font-size: 14px;
            }

            .form-container {
                padding: 30px 25px;
            }
        }

        @media (max-width: 480px) {
            .container {
                border-radius: 15px;
            }

            .illustration {
                padding: 25px 15px;
            }

            .form-container {
                padding: 25px 20px;
            }

            .form-title {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Illustration Section -->
        <div class="illustration">
            <img src="{{ asset('storage/logo.png') }}" class="illustration-img">
            <h2 id="illustration-title">Welcome Back!</h2>
            <p id="illustration-text">Please log in to access your account and manage your church activities.</p>
        </div>

        <!-- Form Section -->
        <div class="form-container">
            <!-- Form Toggle -->
            <div class="form-toggle">
                <div class="toggle-slider login"></div>
                <button class="toggle-btn active" id="login-toggle">Login</button>
                <button class="toggle-btn" id="register-toggle">Register</button>
            </div>

            <!-- Login Form -->
            <div id="login-form" class="form-section active">
                <h2 class="form-title">Welcome Back</h2>
                <p class="form-subtitle">Please enter your credentials to login.</p>

                <!-- Error Message -->
                <div id="login-error" class="alert alert-error hidden">
                    <i class="fas fa-exclamation-circle"></i>
                    <span id="login-error-text">Invalid credentials</span>
                </div>

                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email -->
                    <div class="form-group">
                        <label for="login-email" class="form-label">Email</label>
                        <input type="email" id="login-email" name="email" class="form-input"
                            placeholder="you@example.com" required>
                    </div>
                    @if(session('error'))
                        <label class="text-red-500">{{session('error')}}</label>
                    @endif

                    <!-- Password -->
                    <div class="form-group">
                        <label for="login-password" class="form-label">Password</label>
                        <div class="password-container">
                            <input type="password" id="login-password" name="password" class="form-input"
                                placeholder="••••••••" required>
                            <button type="button" class="password-toggle" id="login-password-toggle">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-btn">Login</button>
                </form>

                <!-- Divider -->
                <div class="divider">
                    <span>or</span>
                </div>

                <!-- Google Login -->
                <a href="{{ route('auth.google') }}" class="google-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    Continue with Google
                </a>

                <!-- Footer Links -->
                <div class="form-footer">
                    <p>Don't have an account? <a href="#" id="go-to-register" class="auth-link">Sign Up</a></p>
                    <a href="{{ route('showForgotPassword') }}" class="auth-link"
                        style="margin-top: 10px; display: inline-block; color: red">Forgot password?</a>
                </div>
            </div>

            <!-- Register Form -->
            <!-- Register Form -->
            <div id="register-form" class="form-section">
                <h2 class="form-title">Create Account</h2>
                <p class="form-subtitle">Please enter your details to register.</p>

                {{-- Session / Global messages --}}
                @if(session('success'))
                    <div id="register-success" class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span id="register-success-text">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div id="register-error" class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span id="register-error-text">{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div id="register-error" class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Please correct the following errors:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="registerForm" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- First Name -->
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-input"
                            placeholder="Enter your first name" value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Middle Name -->
                    <div class="form-group">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" class="form-input"
                            placeholder="Enter your middle name" value="{{ old('middle_name') }}">
                        @error('middle_name')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="form-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-input"
                            placeholder="Enter your last name" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone (Optional) -->
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone (Optional)</label>
                        <input type="text" id="phone" name="phone" class="form-input"
                            placeholder="Enter your phone number" value="{{ old('phone') }}">
                        @error('phone')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address (Optional) -->
                    <div class="form-group">
                        <label for="address" class="form-label">Address (Optional)</label>
                        <input type="text" id="address" name="address" class="form-input"
                            placeholder="Enter your address" value="{{ old('address') }}">
                        @error('address')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- District -->
                    <div class="form-group">
                        <label for="district" class="form-label">District</label>
                        <input type="text" id="district" name="district" class="form-input"
                            placeholder="Enter your district" value="{{ old('district', 'District of Carcar City') }}" required>
                        @error('district')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Locale -->
                    <div class="form-group">
                        <label for="locale" class="form-label">Locale</label>
                        <input type="text" id="locale" name="locale" class="form-input" placeholder="Enter your locale"
                            value="{{ old('locale', 'Locale og Lutopan') }}" required>
                        @error('locale')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Purok/Grupo -->
                    <div class="form-group">
                        <label for="purok_grupo" class="form-label">Purok/Grupo</label>
                        <input type="text" id="purok_grupo" name="purok_grupo" class="form-input"
                            placeholder="Enter your purok/grupo" value="{{ old('purok_grupo') }}" required>
                        @error('purok_grupo')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Birthdate -->
                    <div class="form-group">
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <input type="date" id="birthdate" name="birthdate" class="form-input"
                            value="{{ old('birthdate') }}">
                        @error('birthdate')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sex -->
                    <div class="form-group">
                        <label for="sex" class="form-label">Sex</label>
                        <select id="sex" name="sex" class="form-input">
                            <option value="">Select your sex</option>
                            <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('sex')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Marital Status -->
                    <div class="form-group">
                        <label for="marital_status" class="form-label">Marital Status</label>
                        <select id="marital_status" name="marital_status" class="form-input">
                            <option value="">Select your marital status</option>
                            <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single
                            </option>
                            <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married
                            </option>
                            <option value="separated" {{ old('marital_status') == 'separated' ? 'selected' : '' }}>
                                Separated</option>
                            <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed
                            </option>
                            <option value="annulled" {{ old('marital_status') == 'annulled' ? 'selected' : '' }}>Annulled
                            </option>
                        </select>
                        @error('marital_status')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Baptism Date (Optional) -->
                    <div class="form-group">
                        <label for="baptism_date" class="form-label">Baptism Date (Optional)</label>
                        <input type="date" id="baptism_date" name="baptism_date" class="form-input"
                            value="{{ old('baptism_date') }}">
                        @error('baptism_date')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                  

                    <!-- Supporting Document (Optional) -->
                    <div class="form-group">
                        <label for="document_image" class="form-label">Upload supporting documents (Optional)</label>
                        <input type="file" id="document_image" name="document_image" accept="image/*,application/pdf"
                            class="form-input">
                        @error('document_image')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                      <!-- Transfer Status -->
                    <div class="form-group">
                        <div class="flex items-center">
                            <input type="checkbox" id="isTransferred" name="istransferred" value="1" 
                                class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out"
                                {{ old('istransferred') ? 'checked' : '' }}>
                            <label for="istransferred" class="ml-2 block text-sm text-gray-700">
                                Check if transferred from another locale
                            </label>
                        </div>
                        @error('istransferred')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Transfer Details (Conditional) -->
                    <div id="transferDetails" style="display:none">
                        <!-- Transfer Date -->
                        <div class="form-group">
                            <label for="transferred_when" class="form-label">Transfer Date</label>
                            <input type="date" id="transferred_when" name="transferred_when" class="form-input"
                                value="{{ old('transferred_when') }}">
                            @error('transferred_when')
                                <p class="field-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Transfer From -->
                        <div class="form-group">
                            <label for="transferred_from" class="form-label">Transferred From (Location/Church)</label>
                            <input type="text" id="transferred_from" name="transferred_from" class="form-input"
                                placeholder="Enter previous location/church" value="{{ old('transferred_from') }}">
                            @error('transferred_from')
                                <p class="field-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="register-email" class="form-label">Email</label>
                        <input type="email" id="register-email" name="email" class="form-input"
                            placeholder="you@example.com" value="{{ old('email') }}" required>
                        @error('email')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="register-password" class="form-label">Password</label>
                        <div class="password-container">
                            <input type="password" id="register-password" name="password" class="form-input"
                                placeholder="••••••••" required>
                            <button type="button" class="password-toggle" id="register-password-toggle">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="password-container">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-input" placeholder="••••••••" required>
                            <button type="button" class="password-toggle" id="confirm-password-toggle">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="field-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Fields wrapper (already included above as individual fields) -->
                    <!-- (You can keep or remove the duplicated additional section; fields already appear above) -->

                    <!-- Submit Button -->
                    <button type="submit" class="submit-btn">Register</button>
                </form>

                <!-- Divider -->
                <div class="divider">
                    <span>or</span>
                </div>

                <!-- Google Register -->
                <a href="{{ route('auth.google') }}" class="google-btn" role="button">
                    <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    Sign up with Google
                </a>

                <!-- Footer Links -->
                <div class="form-footer">
                    <p>Already have an account? <a href="#" id="go-to-login" class="auth-link">Log In</a></p>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // DOM Elements
            const loginToggle = document.getElementById('login-toggle');
            const registerToggle = document.getElementById('register-toggle');
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const goToRegister = document.getElementById('go-to-register');
            const goToLogin = document.getElementById('go-to-login');
            const toggleSlider = document.querySelector('.toggle-slider');
            const illustrationTitle = document.getElementById('illustration-title');
            const illustrationText = document.getElementById('illustration-text');
            const toggleFieldsBtn = document.getElementById('toggle-fields-btn');
            const additionalFields = document.getElementById('additional-fields');
            const isTransferred = document.querySelector('#isTransferred');

            
            document.addEventListener('click', function(){
                 if (isTransferred.checked) {
                     document.querySelector('#transferDetails').style.display = 'block'
                 }else{
                    document.querySelector('#transferDetails').style.display = 'hidden'
                 }
            })
          

            // Check if there are validation errors or success message from registration
            const hasRegistrationErrors = {!! $errors->any() && (old('email') || old('first_name') || old('last_name')) ? 'true' : 'false' !!};
            const hasRegistrationSuccess = {!! session('success') ? 'true' : 'false' !!};

            // Form Toggle Functionality
            function showLoginForm() {
                loginToggle.classList.add('active');
                registerToggle.classList.remove('active');
                loginForm.classList.add('active');
                registerForm.classList.remove('active');
                toggleSlider.classList.remove('register');
                toggleSlider.classList.add('login');

                // Update illustration content
                illustrationTitle.textContent = 'Welcome Back!';
                illustrationText.textContent = 'Please log in to access your account and view church activities.';
            }

            function showRegisterForm() {
                registerToggle.classList.add('active');
                loginToggle.classList.remove('active');
                registerForm.classList.add('active');
                loginForm.classList.remove('active');
                toggleSlider.classList.remove('login');
                toggleSlider.classList.add('register');

                // Update illustration content
                illustrationTitle.textContent = 'Join Us Today!';
                illustrationText.textContent = 'Register to participate in church events, view tasks, and stay connected with your brothers and sisters.';
            }

            // Event Listeners for Form Toggle
            loginToggle.addEventListener('click', showLoginForm);
            registerToggle.addEventListener('click', showRegisterForm);
            goToRegister.addEventListener('click', function (e) {
                e.preventDefault();
                showRegisterForm();
            });
            goToLogin.addEventListener('click', function (e) {
                e.preventDefault();
                showLoginForm();
            });

            // Show appropriate form based on page load state
            if (hasRegistrationErrors || hasRegistrationSuccess) {
                showRegisterForm();
            }

            // Password Visibility Toggle
            function setupPasswordToggle(passwordId, toggleId) {
                const passwordInput = document.getElementById(passwordId);
                const toggleButton = document.getElementById(toggleId);

                toggleButton.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle eye icon
                    const icon = toggleButton.querySelector('i');
                    if (type === 'text') {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            }

            // Initialize password toggles
            setupPasswordToggle('login-password', 'login-password-toggle');
            setupPasswordToggle('register-password', 'register-password-toggle');
            setupPasswordToggle('password_confirmation', 'confirm-password-toggle');

            // Additional Fields Toggle
            toggleFieldsBtn.addEventListener('click', function () {
                additionalFields.classList.toggle('show');
                toggleFieldsBtn.classList.toggle('rotate');
            });
        });
    </script>
</body>

</html>