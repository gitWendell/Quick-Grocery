@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="row" style="margin:0; width: 100%">
        <div style="width: 50%">
            <h4 style="text-align: center; width: 100%">Product Trend</h4>
            <div style="width: 100%;">
                {!! $product_trend->container() !!}
            </div>
        </div>
    </div>
    <div class="row" style="margin:0; width: 100%">
        <div class="dashboard-container">
            <div class="dashboard-title">
                <h3>Total Revenue</h3>
            </div>
            <div class="dashboard-body">
                <strong>P {{number_format($totalRevenue,2)}}</strong>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="dashboard-title">
                <h3>Total Profit</h3>
            </div>
            <div class="dashboard-body">
                <strong>P {{number_format($totalProfit,2)}}</strong>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="dashboard-title">
                <h3>Number of active Request Supply</h3>
            </div>
            <div class="dashboard-body">
                <strong>{{$totalActiveSupply}}</strong>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="dashboard-title">
                <h3>Number of orders today</h3>
            </div>
            <div class="dashboard-body">
                <strong>{{$totalOrderToday}}</strong>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="dashboard-title">
                <h3>Total Orders</h3>
            </div>
            <div class="dashboard-body">
                <strong>{{$totalOrder}}</strong>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="dashboard-title">
                <h3>Number of Staffs</h3>
            </div>
            <div class="dashboard-body">
                <strong>{{$totalStaff}}</strong>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/storeadmin/dashboard-controls.js') }}"></script>
    {!! $product_trend->script() !!}
@endsection
