@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Request Supply</h1>
        </div>
    </div>
    <div class="store-content-body">
        <div class="row">
            <div class="column-registerproduct">

            </div>
            <div class="column-searchproduct">
                <input type="text" id="search_requestsupply" placeholder="Search ...">
                <button type="button">Submit</button>
            </div>
            <div class="column-reports">
                <button type="button"><i class="fa fa-file" aria-hidden="true"></i></button>
            </div>
        </div>
        @include('inc.messages')
        <table class="storemanagement-table staffviews" id="storeDatatable">
            <tr class="tr-header">
                <th>Id</th>
                <th>Image</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            @isset($requests)
                @foreach($requests as $request)
                    <tr class="tr-data">
                        <td>{{$request->id}}</td>
                        <td style="text-align: center">
                            <img src="/storage/product_images/{{$request->product->product_image}}" width="100px" height="50px">
                        </td>
                        <td>{{$request->product->name}}</td>
                        <td>{{$request->qty}}</td>
                        <td>{{$request->status}}</td>
                        @if($request->status == 'Confirm')
                            <td class="tr-data-action">
                                <button type="button" disabled>
                                    Update</button>
                            </td>
                        @else
                            <td class="tr-data-action">
                                <button type="button" class="toggleModal-updateRequestSupply primary-btn">
                                    Update</button>
                            </td>
                        @endif

                    </tr>
                @endforeach
            @endisset
        </table>
    </div>
    <div class="store-content-footer">

    </div>
    @section('scripts')
        <script src="{{ asset('js/storeadmin/request-supply/requestsupply.js') }}"></script>
        <script src="{{ asset('js/storeadmin/dashboard-controls.js') }}"></script>
    @endsection
@endsection
