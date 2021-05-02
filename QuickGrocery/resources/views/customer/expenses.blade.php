@extends('customer.inc.layout')

@section('user-account-content')

    <div class="user-dashboard-content">
        <div class="user-dashboard-content-title">
            <div> Expenses </div>
        </div>
        <div class="customer-dashboard-body">
            @include('inc.messages')
            <div class="chart-container">
                {!! $expenses_chart->container() !!}
            </div>
            <div class="row" style="margin: 0">
                <h2 style="width: 50%">Latest (3) Order</h2>
                <div class="column-reports" style="float: right;">
                    <a href="/customer/expenses/pdf" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a>
                </div>

            </div>
            <table class="customer-address" >
                <tr class="tr-header">
                    <th width="10%">Id</th>
                    <th width="30%">Items x Qty</th>
                    <th width="10%">Total</th>
                    <th width="20%">Place On</th>
                    <th width="10%">Status</th>
                </tr>
                @isset($orders)
                    @foreach($orders as $ordermaster)
                        <tr class="tr-data">
                            <td class="tr-data-id">{{$ordermaster->id}} </td>
                            <td>{{$ordermaster->items($ordermaster->id)}}</td>
                            <td>P {{number_format($ordermaster->total($ordermaster->id), 2)}}</td>
                            <td>{{$ordermaster->created_at}}</td>
                            <td>{{$ordermaster->status}}</td>
                        </tr>
                    @endforeach
                @endisset
            </table>
        </div>
    </div>
    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
        {!! $expenses_chart->script() !!}
    @endsection
@endsection
