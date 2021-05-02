@extends('customer.inc.layout')

@section('user-account-content')
    <div class="user-dashboard-content">
        <div class="user-dashboard-content-title">
            <div> Order </div>
        </div>
        <div class="customer-dashboard-body">
            @include('inc.messages')
            <h3>Filter :</h3>
            <div class="row status-selector" style="margin: 0 0 20px 0">
                <a href="?status=All"><span>All</span></a>
                <a href="?status=Pending"><span>Pending</span></a>
                <a href="?status=Reviewed"><span>Reviewed</span></a>
                <a href="?status=Packaging"><span>Packaging</span></a>
                <a href="?status=Ready"><span>Ready</span></a>
                <a href="?status=Received"><span>Received</span></a>
            </div>
            <table id="customer-order-table" class="customer-address" >
                <tr class="tr-header">
                    <th>Id</th>
                    <th>Items x Qty</th>
                    <th>Total</th>
                    <th>Method</th>
                    <th>Billing Address</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @isset($orders)
                    @foreach($orders as $ordermaster)
                        <tr class="tr-data">
                            <td class="tr-data-id">{{$ordermaster->id}} </td>
                            <td>{{$ordermaster->items($ordermaster->id)}}</td>
                            <td>P {{number_format($ordermaster->total($ordermaster->id), 2)}}</td>
                            <td>{{($ordermaster->method == 2) ? 'Pickup' : 'Deliver' }}</td>
                            <td>{{$ordermaster->billing($ordermaster->id)}}</td>
                            <td>{{$ordermaster->status}}</td>
                            <td style="text-align: center">
                                <a href="/customer/view/{{$ordermaster->id}}" class="td-link primary-btn"> View </a>
                            @if($ordermaster->status == 'Packaging' || $ordermaster->status == 'Cancel' || $ordermaster->status == 'Reviewed')
                                <button type="button" disabled> Disable </button>
                            @elseif($ordermaster->status == 'Received')
                                <a href="/customer/review/{{$ordermaster->id}}" class="td-link success-btn">Product Review </a>
                            @elseif($ordermaster->status == 'Ready')
                                <form action="/customer/order/update/{{$ordermaster->id}}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <input type="text" name="status" value="Received" hidden>
                                    <button type="submit" class="primary-btn"> Received </button>
                                </form>
                            @else
                                <button type="button" class="toggleModal-update-orderCust info-btn"> Update </button>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </table>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('js/customer/order.js') }}"></script>
    @endsection
@endsection
