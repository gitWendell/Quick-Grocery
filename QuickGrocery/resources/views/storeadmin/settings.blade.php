@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Store Settings</h1>
        </div>
    </div>
    <div id="settings-content" class="staff-content-body product-content-body">

        <div id="setting-messages">@include('inc.messages')</div>

        <div class="container">
            <form method="POST" id="store-setting-form" data-id="{{$store->id}}"
                  action="/storeadmin/storemanagement/create/{{$store->id}}">
                @csrf
                <div id="refresh-settings">
                    <label for="store_name">Store Name</label>
                    <input class="form-input" type="text" name="store_name" value="{{$store->name}}">

                    <label for="store_description">Store Description</label>
                    <textarea class="form-textarea" name="store_description" id="" cols="30" rows="10" >{{$store->description}}</textarea>

                    <label for="status">Status</label>
                    <select class="form-input" name="status" value="{{$store->status}}">
                        <option value="Active">Active</option>
                        <option value="Block">Block</option>
                    </select>
                    <div class="row" style="margin: 20px 0 !important;">
                        Can Deliver ?
                        <input class="form-checkbox"
                               style="width: 30% !important"
                               type="checkbox" name="can_deliver"
                               value="1" {{($store->candeliver == 0 ) ? '' : "checked"}}>
                        Notify on stock reach
                        <input class="form-input"
                               style="margin-left:50px;width: 30% !important; text-align: center"
                               type="text" name="request_on_stock"
                               value="@if ($settings == null) @else{{($settings->request_on_stock == '' ) ? "" : $settings->request_on_stock}} @endif">
                    </div>
                    <table>
                        <tr>
                            <td><input class="form-checkbox" style="display: none" type="text" name="auto_supply" value="1" hidden></td>
                        </tr>
                    </table>

                    <h2>All Products</h2>( Set stocks request per product )
                    <div class="request_stock_area">
                    @isset($store)
                        @if (sizeof($request_stocks) == 0)
                            @foreach($store->products as $product)
                                <label for="request_stock">{{$product->name}}</label>
                                <input class="form-input" type="text" name="request_product_id[]" value="{{$product->id}}" hidden>
                                <input class    ="form-input" type="text" name="request_stock[]">
                            @endforeach
                        @else
                            @php $repeated = 0; @endphp
                            @foreach($store->products as $product)
                                @if(sizeof($asasd = \App\RequestStock::where('product_id', $product->id)->get()))
                                    <label for="request_stock">{{$product->name}}</label>
                                    <input class="form-input" type="number" min="1" name="request_product_id[]" value="{{$product->id}}" hidden>
                                    <input class="form-input" type="number" min="1" name="request_stock[]" value="{{$asasd->first()->stocks}}">
                                @else
                                    <label for="request_stock">{{$product->name}}</label>
                                    <input class="form-input" type="number" min="1" name="request_product_id[]" value="{{$product->id}}" hidden>
                                    <input class="form-input" type="number" min="1" name="request_stock[]">
                                @endif
                            @endforeach
                        @endif
                    @endisset
                    </div>
                </div>
                <div class="button">
                    <button type="submit"> Submit </button>
                </div>
            </form>
        </div>
    </div>
    <div class="store-content-footer">

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/storeadmin/dashboard-controls.js') }}"></script>
    <script src="{{ asset('js/storeadmin/store-settings.js') }}"></script>
@endsection
