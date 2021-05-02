@extends('customer.inc.layout')

@section('user-account-content')
    <div class="user-dashboard-content">
        <div class="user-dashboard-content-title">
            <div> Account Details </div>
        </div>
        <div class="container">
            <div class="customer-dashboard-body">
                <div id="account-message">@include('inc.messages')</div>
                <form method="POST" id="account-update" data-id="{{Auth::id()}}" action="{{ action('Customer\AccountController@update', Auth::id()) }}" >
                    @csrf
                    <div class="row" style="margin: 0;">
                        <div id="account-refresh" style="width: 100%">

                            <label class="form-label" for="email" style="display: block">Name</label>
                            <input class="form-input" type="text" name="name" value="{{Auth::user()->name}}">

                            <label class="form-label" for="email" style="display: block">Email</label>
                            <input class="form-input" type="text" name="email" value="{{Auth::user()->email}}">

                            <label class="form-label" for="password">Password</label>
                            <input class="form-input" type="password" name="password">

                            <label class="form-label" for="confirm_password">Confirm Password</label>
                            <input class="form-input" type="password" name="password_confirmation">
                        </div>
                        <div class="customer-dashboard-body-buttons">
                        <button type="submit">UPDATE</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/customer/account.js') }}"></script>
@endsection
