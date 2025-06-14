@extends('layout.form')
@section('title', 'Login')
@section("subtitle", "Please enter your credentials to login.")
@section("form-action", route('login'))

@section("form-fields")
    <x-form.field label="Email" name="email" type="email" placeholder="you@example.com" :error="$errors->first('email')" />
    <x-form.field label="Password" name="password" type="password" placeholder="••••••••"
        :error="$errors->first('password')" />
@endsection

@section("form-button-text")
    Login
@endsection

@section("footer-text")
    <p>Already have an account? <a href="{{ route('showRegisterForm') }}" class="auth-link">Sign Up</a></p>
    <a href="#" class="forgot-password auth-link">Forgot password?</a>
@endsection