@extends('systemadmin.inc.layout')

@section('sidebar-content')
    <div class="row dashboard-lang" style="margin: 0 auto">
        <div class="row" style="margin:0; width: 100%">
            <div style="width: 50%;">
                {!! $account_chart->container() !!}
            </div>
            <div style="width: 50%;">
                {!! $store_chart->container() !!}
            </div>
        </div>
        <div class="row" style="margin:20px 0; width: 100%">
            <div style="text-align: center; width: 50%">
                <h4>Stores Trend</h4>
                <div style="width: 100%;">
                    {!! $most_used_store->container() !!}
                </div>
            </div>
            <div style="text-align: center; width: 50%">
                <h4>Active User and Block User</h4>
                <div style="width: 100%;">
                    {!! $activeAndBlockUser->container() !!}
                </div>
            </div>
        </div>
        <br/>
        <div class="dashboard-container">
            <div class="dashboard-title">
                <h3>Account Registered</h3>
            </div>
            <div class="dashboard-body">
                <strong>{{$usersTotal}}</strong>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="dashboard-title">
                <h3>Store Registered</h3>
            </div>
            <div class="dashboard-body">
                <strong>{{$storeTotal}}</strong>
            </div>
        </div>
        <div class="dashboard-container">
            <div class="dashboard-title">
                <h3>Rewards</h3>
            </div>
            <div class="dashboard-body">
                <strong>{{$rewardTotal}}</strong>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/systemadmin/dashboard-controls.js') }}"></script>
    {!! $account_chart->script() !!}
    {!! $store_chart->script() !!}
    {!! $most_used_store->script() !!}
    {!! $activeAndBlockUser->script() !!}
@endsection
