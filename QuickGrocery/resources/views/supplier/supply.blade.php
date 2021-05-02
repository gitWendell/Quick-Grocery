@extends('supplier.inc.layout')

@section('sidebar-content')
<div class="store-content-header">
    <div class="header-title">
        <h1>Request Stock Management</h1>
    </div>
</div>
<div class="store-content-body">
    <div class="row">
        <div class="column-registerproduct">
        </div>
        <div class="column-searchproduct">
            <input type="text" placeholder="Search ...">
            <button type="button">Submit</button>
        </div>
        <div class="column-reports">
            <button type="button"><i class="fa fa-file" aria-hidden="true"></i></button>
        </div>
    </div>
    @include('inc.messages')
    <table class="storemanagement-table staffviews" id="storeDatatable">
        <tr class="tr-header">
            <th width="10%">Id</th>
            <th width="30%">Product Name</th>
            <th width="30%">Product Description</th>
            <th width="20%">Stocks</th>
            <th width="20%">Status</th>
            <th width="20%">Action</th>
        </tr>
        @isset($request_stocks)
            @foreach($request_stocks as $request_stock)
                @if($request_stock->status == 'Request' || $request_stock->status == 'Delivering')
                    <tr class="tr-data">
                        <td class="tr-data-action">{{$request_stock->id}}</td>
                        <td>{{$request_stock->product->name}}</td>
                        <td>{{$request_stock->product->description}}</td>
                        <td>{{$request_stock->stocks}}</td>
                        <td>{{$request_stock->status}}</td>
                        <td class="tr-data-action"><button type="button" class="toggleModal-updateRequestStock">Update</button></td>
                    </tr>
                @endif
            @endforeach
        @endisset

    </table>
</div>
@section('scripts')
    <script src="{{ asset('js/supplier/request_stock.js') }}"></script>
@endsection

@endsection
