@extends('layouts.app')
@php
    $innerHeader = 'My account';
    $innerHeaderPara = 'Home / My account';
@endphp
@include('inc/inner-header')

@section('content')
<!-- Login Form -->
<section id="loginRegister">
    <h1>LOGIN OR CREATE AN ACCOUNT</h1>
    <div class="area register-area">
        <h3>NEW CUSTOMERS</h3>
        <p>By creating an account with our system, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
        <button onclick="window.location='register';" type="button" name="createAccount" class="register"><span>Create an Account</span></button>
    </div>

    <div class="area login-area">

        <h3>REGISTERED USERS</h3>
        <p>If you have an account with us, please log in.</p>
        @include('inc.messages')
        <form method="POST" action="{{ route('login.custom') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input rememberInput" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary login">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link lostPassword" href="{{ route('password.request') }}">
                            {{ __('Lost your password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>

    </div>
</section>

@endsection
