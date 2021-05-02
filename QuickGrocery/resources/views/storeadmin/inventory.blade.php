@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Inventory Management</h1>
        </div>
    </div>
    <div class="store-content-body">
        <div class="row">
            <div class="column-registerproduct">
            </div>
            <div class="column-searchproduct">
                <input type="text" id="search_inventory" name="search" placeholder="Search ...">
                <button type="button">Submit</button>
            </div>
            <div class="column-reports">
                <a href="/store-admin/account/pdf" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a>
            </div>
        </div>
        @include('inc.messages')
        <table class="storemanagement-table" id="storeDatatable">
            <thead>
                <tr class="tr-header">
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th style="width: 30%;">Description</th>
                    <th>Stock</th>
                    <th>Supplier Price</th>
                    <th>Selling Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <div style="display: none;">{{$count=1}}</div>
            <tbody>
            @isset($store)
                @foreach ($store->products as $product)
                    <tr class="tr-data">
                        <td>{{$product->id}}</td>
                        <td style="text-align: center">
                            <img src="/storage/product_images/{{$product->product_image}}" width="100px" height="50px">
                        </td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->description}}</td>
                        <td class="tr-data-action">{{$product->getStocks($product->id)}}</td>
                        <td class="tr-data-action">P {{ number_format($product->price, 2) }}</td>
                        <td class="tr-data-action">P {{ number_format($product->selling_price, 2) }}</td>
                        <td class="tr-data-action">
                        @can('update', $product)
                                <button class="updateProduct-modal primary-btn">Update</button>
                        @endcan
                        </td>

                    </tr>
                @endforeach
            @endisset
            </tbody>
        </table>
    </div>
    <div class="store-content-footer">

    </div>
    @section('scripts')
        <script src="{{ asset('js/storeadmin/inventory-list-assets/inventory.js') }}"></script>
        <script src="{{ asset('js/storeadmin/dashboard-controls.js') }}"></script>
    @endsection
@endsection
