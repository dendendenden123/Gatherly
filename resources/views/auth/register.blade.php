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

@section("form-button-text")
    Register
@endsection

@section("footer-text")
    <p>Already have an account? <a href="{{ route('showLoginForm') }}" class="auth-link">Log In</a></p>
@endsection