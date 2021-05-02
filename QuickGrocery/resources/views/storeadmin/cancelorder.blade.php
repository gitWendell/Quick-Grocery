@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Canceled Order</h1>
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
        <table class="storemanagement-table staffviews" id="storeDatatable">
            <tr class="tr-header">
                <th>Id</th>
                <th>Name</th>
                <th>Items x Qty</th>
                <th>Total</th>
            </tr>
            @isset($orders)
                @foreach($orders as $ordermaster)
                    @if($ordermaster->status == 'Cancel')
                        <tr class="tr-data">
                            <td class="tr-data-id">{{$ordermaster->id}} </td>
                            <td class="tr-data-id">{{$ordermaster->users->name}} </td>
                            <td>{{$ordermaster->items($ordermaster->id)}}</td>
                            <td>P {{number_format($ordermaster->total($ordermaster->id), 2)}}</td>
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
