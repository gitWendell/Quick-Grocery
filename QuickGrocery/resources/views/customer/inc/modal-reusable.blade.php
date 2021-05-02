@if( Request::segment(2) == 'reusablecart' && Request::segment(1) == 'customer')
<div class="update-reusable-modal update-reusable-hidden">
    <div class="modal-content" style="width: 80% !important;">
        <div class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>Update Reusable Cart</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="update-reusable-modal-close"></i>
                </div>
            </div>
        </div>
        <div class="store-modal-body" >
            <div id="message-success">

            </div>
            <form method="POST" action="/" id="update-orderCust-frm"
                  style="width: 100% !important; padding: 0; margin: 0 auto;
                  overflow-y: scroll;height: 550px;overflow-x: hidden;">
                @csrf
                <div class="row"
                     style="margin: 0 0 15px 0">
                    <h3 style="width: fit-content;margin-right: 5%">Store List</h3>
                    <input type="text" style="width: 50%;" class="search_store" name="search_store" placeholder="Search">
                </div>
                <div class="row reusable-store-list">
                    @isset($stores)
                        @foreach ($stores as $store)
                            @if($store->status == 'Block')
                            @else
                                <div class="location-content-card">
                                    <div class="location-content-store" >
                                        <div class="location-content-store-header">
                                            <img src="/storage/store_images/{{$store->store_image}}" width="200px" height="100px">
                                        </div>
                                        <div class="location-content-store-body">
                                            <div class="location-content-card-name">
                                                <h5>{{$store->name}}</h5>
                                            </div>
                                            <div class="location-content-card-description">
                                                <p>{{$store->description}}</p>
                                            </div>
                                        </div>
                                        <div class="location-content-store-footer">
                                            <button type="button" data-id="{{$store->id}}" class="store-select"> SELECT</button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endforeach
                    @endisset
                </div>
                <div class="row" id="product-list"
                     style="margin: 0 0 15px 0; display: none">
                    <h3 style="width: fit-content;margin-right: 5%">Product List</h3>
                    <input type="text" style="width: 50%;" class="search_product" name="search_product" placeholder="Search">
                </div>
                <div id="reusable-product">

                </div>

                <h3>Current Reusable List</h3>
                <table class="customer-address" width="100%" >
                    <tr class="tr-header">
                        <th width="20%">Id</th>
                        <th width="50%">Item x Qty</th>
                        <th width="30%">Total</th>
                    </tr>
                    <tr id="current-reusable-list" >

                    </tr>
                </table>
                <div class="button-add-brand">
                    <a class="addbrandButton" href="/customer/reusablecart">RELOAD</a>
                </div>
            </form>
        </div>
        <div class="store-modal-footer">

        </div>
    </div>
</div>@endif
