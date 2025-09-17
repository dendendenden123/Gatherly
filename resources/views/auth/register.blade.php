@extends('layouts.form')
@section('title', 'Register')
@section("subtitle", "Please enter your credentials to register.")
@section("form-action", route('register'))

@section("form-fields")
    <!-- Display success/error messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Please correct the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- first name -->
    <x-form.field label="First Name" name="first_name" type="text" placeholder="Enter your first name"
        :error="$errors->first('first_name')" />

    <!-- middle name -->
    <x-form.field label="Middle Name" name="middle_name" type="text" placeholder="Enter your middle name"
        :error="$errors->first('middle_name')" />

    <!-- last name -->
    <x-form.field label="Last Name" name="last_name" type="text" placeholder="Enter your last name"
        :error="$errors->first('last_name')" />

    <!-- phone -->
    <x-form.field label="Phone (Optional)" name="phone" type="text" placeholder="Enter your phone number"
        :error="$errors->first('phone')" :required="false" />

    <!-- address -->
    <x-form.field label="Address (Optional)" name="address" type="text" placeholder="Enter your address"
        :error="$errors->first('address')" :required="false" />

    <!-- district -->
    <x-form.field label="District" name="district" type="text" placeholder="Enter your district"
        :error="$errors->first('district')" />

    <!-- locale -->
    <x-form.field label="Locale" name="locale" type="text" placeholder="Enter your locale"
        :error="$errors->first('locale')" />

    <!-- purok_grupo -->
    <x-form.field label="Purok/Grupo" name="purok_grupo" type="text" placeholder="Enter your purok/grupo"
        :error="$errors->first('purok_grupo')" />

    <!-- birthdate -->
    <x-form.field label="Birthdate" name="birthdate" type="date" :error="$errors->first('birthdate')" />

    <!-- sex -->
    <x-form.field label="Sex" name="sex" type="select" :error="$errors->first('sex')">
        <option value="">Select your sex</option>
        <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
    </x-form.field>

    <!-- Marital Status -->
    <x-form.field label="Marital Status" name="marital_status" type="select" :error="$errors->first('marital_status')">
        <option value="">Select your marital status</option>
        <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
        <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
        <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
        <option value="separated" {{ old('marital_status') == 'separated' ? 'selected' : '' }}>Separated</option>
        <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
        <option value="engaged" {{ old('marital_status') == 'engaged' ? 'selected' : '' }}>Engaged</option>
        <option value="civil union" {{ old('marital_status') == 'civil union' ? 'selected' : '' }}>Civil Union</option>
        <option value="domestic partnership" {{ old('marital_status') == 'domestic partnership' ? 'selected' : '' }}>Domestic
            Partnership</option>
        <option value="annulled" {{ old('marital_status') == 'annulled' ? 'selected' : '' }}>Annulled</option>
    </x-form.field>

    <!-- baptism date -->
    <x-form.field label="Baptism Date (Optional)" name="baptism_date" type="date" :error="$errors->first('baptism_date')"
        :required="false" />

    <!-- Upload your supporting documents(NSO Livebirth etc)-->
    <x-form.field name="document_image" type="file" accept="image/*,application/pdf"
        label="Upload supporting documents (Optional)" aria-placeholder="NSO, Livebirth and PSA etc"
        :error="$errors->first('document_image')" :required="false" />

    <!-- email -->
    <x-form.field label="Email" name="email" type="email" placeholder="you@example.com" :error="$errors->first('email')" />

    <!-- password -->
    <x-form.field label="Password" name="password" type="password" placeholder="••••••••"
        :error="$errors->first('password')" />

    <!-- Confirm Password -->
    <x-form.field label="Confirm Password" name="password_confirmation" type="password" placeholder="••••••••"
        :error="$errors->first('password_confirmation')" />
@endsection

@section("google-auth")
    <div class="google-auth-section">
        <div class="divider">
            <span>or</span>
        </div>
        <a href="{{ route('auth.google') }}" class="google-auth-button">
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
    </div>
@endsection

@section("form-button-text")
    Register
@endsection

@section("footer-text")
    <p>Already have an account? <a href="{{ route('showLoginForm') }}" class="auth-link">Log In</a></p>
@endsection