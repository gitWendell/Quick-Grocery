@extends('layouts.app')

@php
    $innerHeader = 'My Account';
    $innerHeaderPara = 'Customer / Dashboard';
@endphp
@include('inc/inner-header')

@section('content')
    <section id="user-dashboard">
        <div class="row">
            <div class="user-dashboard-sidebar">
                <div class="user-dashboard-name">
                    <img src="{{asset('images/naruto.jpg')}}" alt="" width="100px" height="100px">
                    <p> {{ Auth::user()->name }}</p>
                </div>
                <ul>
                    <a href="/customer/dashboard">
                        <li class="{{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">Dashboard</li>
                    </a>
                    <a href="/customer/reusablecart">
                        <li class="{{ (request()->segment(2) == 'reusablecart') ? 'active' : '' }}">Reusable Cart</li>
                    </a>
                    <a href="/customer/order">
                        <li class="{{ (request()->segment(2) == 'order') ? 'active' : '' }}"> Orders</li>
                    </a>
                    <a href="/customer/addresses">
                        <li class="{{ (request()->segment(2) == 'addresses') ? 'active' : '' }}">Addresses</li>
                    </a>
                    <a href="/customer/accountdetails">
                        <li class="{{ (request()->segment(2) == 'accountdetails') ? 'active' : '' }}">Account Details</li>
                    </a>
                    <a href="/customer/expenses">
                        <li class="{{ (request()->segment(2) == 'expenses') ? 'active' : '' }}">Expenses</li>
                    </a>
                </ul>
            </div>

            @yield('user-account-content')

        </div>
    </section>
@endsection
@section('include-this')
    @if ( Request::segment(1) == 'customer')
        @include('customer.inc.modal-billing')
        @include('customer.inc.modal-order')
        @include('customer.inc.modal-reusable')
    @endif
@endsection
