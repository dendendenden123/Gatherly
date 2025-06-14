@extends('layout.form')
@section('title', 'Register')
@section("subtitle", "Please enter your credentials to register.")
@section("form-action", route('register'))

@section("form-fields")
    <!-- first name -->
    <x-form.field label="First Name" name="first_name" type="text" placeholder="Enter your first name"
        :error="$errors->first('first_name')" />

    <!-- middle name -->
    <x-form.field label="Middle Name" name="middle_name" type="text" placeholder="Enter your middle name"
        :error="$errors->first('middle_name')" />

    <!-- last name -->
    <x-form.field label="Last Name" name="last_name" type="text" placeholder="Enter your last name"
        :error="$errors->first('last_name')" />

    <!-- Role -->
    <x-form.field label="Role" name="role" type="select" :error="$errors->first('role')">
        <option value="">Select your role</option>
        <option value="Finance" {{ old('role') == 'Finance' ? 'selected' : '' }} disabled>Finance</option>
        <option value="SCAN" {{ old('role') == 'SCAN' ? 'selected' : '' }}>SCAN</option>
        <option value="Deacon" {{ old('role') == 'Deacon' ? 'selected' : '' }}>Deacon</option>
        <option value="Kalihim" {{ old('role') == 'Kalihim' ? 'selected' : '' }}>Kalihim</option>
        <option value="Choir" {{ old('role') == 'Choir' ? 'selected' : '' }}>Choir</option>
        <option value="None" {{ old('role') == 'None' ? 'selected' : '' }}>None</option>
    </x-form.field>

    <!-- phone -->
    <x-form.field label="Phone" name="phone" type="text" placeholder="Enter your phone number"
        :error="$errors->first('phone')" />

    <!-- address -->
    <x-form.field label="Address" name="address" type="text" placeholder="Enter your address"
        :error="$errors->first('address')" />

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
    <x-form.field label="Baptism Date" name="baptism_date" type="date" :error="$errors->first('baptism_date')" />

    <!-- Upload your supporting documents(NSO Livebirth etc)-->
    <x-form.field name="document_image" type="file" accept="image/*" label="Upload supporting documents"
        aria-placeholder="NSO, Livebirth and PSA etc" :error="$errors->first('document_image')" />

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