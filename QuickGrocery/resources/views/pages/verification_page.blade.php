@extends('layouts.app')

@include('inc/inner-header-location')

@section('content')
    <div class="container">
        <section class="finished-checkout container">
            <div class="finished-checkout-header" style="text-align: center">
                <h1 style="padding: 50px">
                    Verify Account<br/>
                    Please check your email to verify your account.<br/>
                    Thank you!
                </h1>
            </div>
            <div class="location-content-store-footer" style="text-align: center;margin: 10px 0">
                <a href="/login"><i class="fa fa-user"></i> Proceed to Login</a>
            </div>
        </section>
    </div>
@endsection
