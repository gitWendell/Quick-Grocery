@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Order Management</h1>
        </div>
    </div>
    <div class="store-content-body">
        <div class="row">
            <div class="column-registerproduct">
            </div>
            <div class="column-searchproduct">
                <input type="text" id="search_order" placeholder="Search ...">
                <button type="button">Submit</button>
            </div>
            <div class="column-reports">
                <a href="/store-admin/order/pdf" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a>
            </div>
        </div>
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
        <table class="storemanagement-table staffviews" id="storeDatatable">
            <tr class="tr-header">
                <th>Id</th>
                <th>Name</th>
                <th>Items x Qty</th>
                <th>Total</th>
                <th>Method</th>
                <th>Billing Address</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
                @isset($orders)
                    @foreach($orders as $ordermaster)
                        @if($ordermaster->status != 'Cancel')
                            <tr class="tr-data">
                                <td class="tr-data-id">{{$ordermaster->id}} </td>
                                <td class="tr-data-id">{{$ordermaster->users->name}} </td>
                                <td>{{$ordermaster->items($ordermaster->id)}}</td>
                                <td>P {{number_format($ordermaster->total($ordermaster->id), 2)}}</td>
                                <td>{{($ordermaster->method == 2) ? 'Pickup' : 'Deliver' }}</td>
                                <td>{{($ordermaster->billing == '') ? 'No Billing Address' : $ordermaster->billing_address->city->citymunDesc. ', '.  $ordermaster->billing_address->barangay->brgyDesc}}</td>
                                <td>{{$ordermaster->status}}</td>
                                <td class="tr-data-action">
                                    @can('update', $ordermaster)
                                        @if($ordermaster->status == 'Cancel' || $ordermaster->status == 'Reviewed' || $ordermaster->status == 'Confirm')
                                            <button type="button" disabled>Update</button>
                                        @else
                                            <a href="/storeadmin/ordermanagement/view/{{$ordermaster->id}}"
                                               class="primary-btn td-link">
                                                View
                                            </a>
                                            <button type="button" class="toggleModal-updateOrder">Update</button>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endisset
        </table>
    </div>
    <div class="store-content-footer">

    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/storeadmin/order-list-assets/order.js') }}"></script>
    <script src="{{ asset('js/storeadmin/dashboard-controls.js') }}"></script>
@endsection
