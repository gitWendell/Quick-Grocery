@extends('layouts.app')

@section('content')
    <div class="row" style="margin-right:0;">
        <div class="store-sidebar">
            <div class="dashboard-header">
                <img src="{{asset('images/naruto.jpg')}}" >
                <p> {{ Auth::user()->name }}</p>
            </div>
            <div class="dashboard-content">
                <ul>
                    <a href="/supplier/dashboard">
                        <li class="{{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">Dashboard</li>
                    </a>
                    <a href="/supplier/supplymanagement">
                        <li class="{{ (request()->segment(2) == 'supplymanagement' && request()->segment(3) == '') ? 'active' : ''}}">
                            Supply Management </li>
                    </a>
                </ul>
            </div>
        </div>

        <div class="store-sidebar-content">
            @yield('sidebar-content')
        </div>
    </div>

    {{-- Scripts --}}
@endsection
@section('include-this')
    @if ( Request::segment(1) == 'supplier')
        @include('supplier.inc.modal-request_stock')
    @endif
@endsection
