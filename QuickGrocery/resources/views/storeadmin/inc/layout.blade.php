@extends('layouts.app')

@section('content')
<div class="row" style="margin-right:0;">
    <div class="store-sidebar">
        <span style="float: right " class="dashboard-closer-span"><i class="fa fa-close dashboard-closer"></i></span>
        <div class="dashboard-header">
            <img src="{{asset('images/naruto.jpg')}}" >
            <p> {{ Auth::user()->name }}</p>
        </div>
        <div class="dashboard-content">
            <ul>
                <a href="/storeadmin/dashboard">
                    <li class="{{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">Dashboard</li>
                </a>

                @if(auth()->user()->role == 'storeadmin')
                    <a href="/storeadmin/accountmanagement">
                        <li class="{{ (request()->segment(2) == 'accountmanagement') ? 'active' : '' }}">Account Management</li>
                    </a>
                    <a href="/storeadmin/storemanagement">
                        <li class="{{ (request()->segment(2) == 'storemanagement') ? 'active' : '' }}">Store Management</li>
                    </a>
                    <a href="/storeadmin/staffmanagement">
                        <li class="{{ (request()->segment(2) == 'staffmanagement' && request()->segment(3) == '') ? 'active' : '' }}">Staff Management</li>
                    </a>
                    <ul class="{{ (request()->segment(2) == 'staffmanagement') ? 'dropdown-dashboard' : '' }}">
                        <a href="/storeadmin/staffmanagement/addstaff">
                            <li class="{{ (request()->segment(3) == 'addstaff') ? 'active' : '' }}" >Add Staff</li>
                        </a>
                    </ul>
                @endif

                @can('inventory', \App\Product::class)
                    <a href="/storeadmin/inventorymanagement">
                        <li class="{{ (request()->segment(2) == 'inventorymanagement' && request()->segment(3) == '') ? 'active' : ''}}">
                            Inventory Management </li>
                    </a>
                    <ul class="{{ (request()->segment(2) == 'inventorymanagement') ? 'dropdown-dashboard' : '' }}">
                        <a href="/storeadmin/inventorymanagement/brand">
                            <li class="{{ (request()->segment(3) == 'brand') ? 'active' : '' }}" >Brand</li>
                        </a>
                        <a href="/storeadmin/inventorymanagement/category">
                            <li class="{{ (request()->segment(3) == 'category') ? 'active' : '' }}">Category</li>
                        </a>
                        <a href="/storeadmin/inventorymanagement/attribute">
                            <li class="{{ (request()->segment(3) == 'attribute') ? 'active' : '' }}">Attribute</li>
                        </a>
                        @can('create', \App\Product::class)
                        <a href="/storeadmin/inventorymanagement/addproduct">
                            <li class="{{ (request()->segment(3) == 'addproduct') ? 'active' : '' }}">Add Product</li>
                        </a>
                        @endcan
                    </ul>
                @endcan

                @can('order', \App\OrderMaster::class)
                    <a href="/storeadmin/ordermanagement">
                        <li class="{{ (request()->segment(2) == 'ordermanagement' && request()->segment(3) == '') ? 'active' : ''}}">
                            Order Management </li>
                    </a>
                    <ul class="{{ (request()->segment(2) == 'ordermanagement') ? 'dropdown-dashboard' : '' }}">
                        <a href="/storeadmin/ordermanagement/canceledorder">
                            <li class="{{ (request()->segment(3) == 'canceledorder') ? 'active' : '' }}" >Canceled Order</li>
                        </a>
                    </ul>
                @endcan
                <a href="/storeadmin/supply">
                    <li class="{{ (request()->segment(2) == 'supply' && request()->segment(3) == '') ? 'active' : ''}}">
                        Request Supply </li>
                </a>
            </ul>
        </div>
    </div>

    <span style="float: right " class="dashboard-opener-span">
        <i class="fa fa-align-justify dashboard-opener"></i>
    </span>

    <div class="store-sidebar-content">
        @yield('sidebar-content')
    </div>
</div>
{{-- Scripts --}}

@endsection

@section('include-this')
    @if ( Request::segment(1) == 'storeadmin')
        @include('storeadmin.inc.modal-inventory')
        @include('storeadmin.inc.modal-staff')
        @include('storeadmin.inc.modal-order')
        @include('storeadmin.inc.modal-supplier')
        @include('storeadmin.inc.modal-requestsupply ')
    @endif
@endsection

