@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Account Management</h1>
        </div>
    </div>
    <div id="settings-content" class="staff-content-body product-content-body">
        <div id="setting-messages">@include('inc.messages')</div>
        <div class="container">
            <form method="POST" action="/storeadmin/accountmanagement/update/{{Auth::id()}}">
                @csrf
                <div id="refresh-settings">
                    <label for="store_name">Display Name</label>
                    <input class="form-input" type="text" name="name" value="{{Auth::user()->name}}">

                    <label for="store_description">Email</label>
                    <input class="form-input" type="email" name="email" value="{{Auth::user()->email}}">

                    <label for="store_description">Password</label>
                    <input class="form-input" type="password" name="password">

                    <label for="store_description">Confirm Password</label>
                    <input class="form-input" type="password" name="password_confirmation">
                </div>
                <div class="button">
                    <button type="submit"> Submit </button>
                </div>
            </form>
        </div>
    </div>
    <div class="store-content-footer">

    </div>
@endsection
