@extends('layouts.app')

@section('content')
<div class="row" style="margin-right:0;">
    <div class="systemadmin-sidebar">
        <span style="float: right " class="dashboard-closer-span"><i class="fa fa-close dashboard-closer"></i></span>
        <div class="dashboard-header">
            <img src="{{asset('images/naruto.jpg')}}" >
            <p> {{ Auth::user()->name }}</p>
        </div>
        <div class="dashboard-content">
            <ul>
                <a href="/systemadmin/dashboard">
                    <li class="{{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">Dashboard</li>
                </a>
                <a href="/systemadmin/accountmanagement">
                    <li class="{{ (request()->segment(2) == 'accountmanagement') ? 'active' : '' }}">Account Management</li>
                </a>
                <a href="/systemadmin/storemanagement">
                    <li class="{{ (request()->segment(2) == 'storemanagement') ? 'active' : '' }}">Store Management</li>
                </a>
                <a href="/systemadmin/reward">
                    <li class="{{ (request()->segment(2) == 'reward') ? 'active' : '' }}">Reward Management </li>
                </a>
            </ul>
        </div>
    </div>

    <span style="float: right " class="dashboard-opener-span">
        <i class="fa fa-align-justify dashboard-opener"></i>
    </span>

    <div class="systemadmin-sidebar-content">
        @yield('sidebar-content')
    </div>
</div>

{{-- Scripts --}}
@endsection

@section('include-this')
    @if ( Request::segment(1) == 'systemadmin')
        @include('systemadmin.inc.modal-store')
        @include('systemadmin.inc.modal-account')
        @include('systemadmin.inc.modal-reward')
    @endif
@endsection
