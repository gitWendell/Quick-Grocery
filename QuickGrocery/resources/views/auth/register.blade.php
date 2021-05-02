@extends('layouts.app')
@php
    $innerHeader = 'Register Account';
    $innerHeaderPara = 'Home / Register account';
@endphp
@include('inc/inner-header')

@section('content')
<section id="user-register">
    <div class="container">
        <h1 style="text-align: center">Create your QuickGrocery Account</h1>
            <form id="register-form" method="POST" action="{{ route('register') }}" data-parsley-validate>
                @csrf

                <div class="form-group ">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Display name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name"
                               value="{{ old('name') }}"
                               required autocomplete="name"
                               data-parsley-length="[6,15]"
                               data-parsley-trigger="keyup"
                               autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                    <label for="role" class="col-md-4 col-form-label text-md-right" hidden>{{ __('Role') }}</label>

                    <div class="col-md-6">
                        <input id="role" type="text" class="form-control @error('role') is-invalid @enderror" name="role" value="customer" required autocomplete="role" hidden>

                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password"
                               type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required
                               data-parsley-length="[6,15]"
                               data-parsley-trigger="keyup"
                               autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
                <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes</p>
                <p>already have an account ? <a href="/login">Click Here</a></p>

                <div class="form-group  mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary user-register">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
    </div>
</section>
@endsection

@section('scripts')
    <script>
        $('#register-form').parsley();
    </script>
@endsection
