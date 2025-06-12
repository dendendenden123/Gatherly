@extends('layout.form')
@section('title', 'Register')
@section("subtitle", "Please enter your credentials to register.")

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
    <!-- email -->
    <x-form.field label="Email" name="email" type="email" placeholder="you@example.com" :error="$errors->first('email')" />
    <!-- password -->
    <x-form.field label="Password" name="password" type="password" placeholder="••••••••"
        :error="$errors->first('password')" />
    <!-- first name -->
    <x-form.field label="First Name" name="first_name" type="text" placeholder="Enter your first name"
        :error="$errors->first('first_name')" />
    <!-- middle name -->
    <x-form.field label="Middle Name" name="middle_name" type="text" placeholder="Enter your middle name"
        :error="$errors->first('middle_name')" />
    <!-- last name -->
    <x-form.field label="Last Name" name="last_name" type="text" placeholder="Enter your last name"
        :error="$errors->first('last_name')" />
    <!-- email -->
    <x-form.field label="Email" name="email" type="email" placeholder="you@example.com" :error="$errors->first('email')" />
    <!-- password -->
    <x-form.field label="Password" name="password" type="password" placeholder="••••••••"
        :error="$errors->first('password')" />
@endsection

@section("form-button-text")
    Register
@endsection

@section("footer-text")
    <p>Already have an account? <a href="{{ route('login') }}" class="auth-link">Log In</a></p>
@endsection