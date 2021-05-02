@if(session()->has('key'))
    <div class="update-compare-product compare-product-hidden" style="margin-top: -50px; overflow: auto">
        <div class="modal-content"
             style="height: 80%;width: 90%; overflow: auto; z-index: 99999">
            <div class="store-modal-header">
                <div class="row" style="margin: 0">
                    <div class="modal-header-title">
                        <h3>Compare</h3>
                    </div>
                    <div class="modal-header-close">
                        <i class="fa fa-times" id="compare-product-modal-close"></i>
                    </div>
                </div>
            </div>
            <div class="store-modal-body">
                <table class="storemanagement-table" style="width: 100%; overflow-x: auto">
                    <thead>
                        <tr class="tr-header">
                            <th width="10%"></th>
                            @foreach(session()->get('key') as $product)
                                <th>{{$product->name}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody >
                        <tr class="tr-data">
                            <td>Image</td>
                            @foreach(session()->get('key') as $product)
                                <td align="center"><img src="/storage/product_images/{{$product->product_image}}" width="200px" height="120px"></td>
                            @endforeach
                        </tr>
{{--                        <tr class="tr-data">--}}
{{--                            <td>Description</td>--}}
{{--                            @foreach(session()->get('key') as $product)--}}
{{--                                <td width="40%">{{$product->description}}</td>--}}
{{--                            @endforeach--}}
{{--                        </tr>--}}
{{--                        <tr class="tr-data">--}}
{{--                            <td>Brand</td>--}}
{{--                            @foreach(session()->get('key') as $product)--}}
{{--                                <td>{{$product->brand->name}}</td>--}}
{{--                            @endforeach--}}
{{--                        </tr>--}}
{{--                        <tr class="tr-data">--}}
{{--                            <td>Category</td>--}}
{{--                            @foreach(session()->get('key') as $product)--}}
{{--                                <td>{{$product->subcategory->category->name}} / {{$product->subcategory->name}}</td>--}}
{{--                            @endforeach--}}
{{--                        </tr>--}}
                        <tr class="tr-data">
                            <td>Price</td>
                            @foreach(session()->get('key') as $product)
                                <td>P <strong>{{number_format($product->price) }}</td>
                            @endforeach
                        </tr>
                        <tr class="tr-data">
                            <td>Action</td>
                            @foreach(session()->get('key') as $product)
                                <td>
                                    <form method="post" action="{{ route('product.addtocart', ['id' => $product->id]) }}" style="text-align: center">
                                        @csrf
                                        <input type="text"
                                               class="form-input"
                                               name="qty"
                                               placeholder="Qty:{{$product->getStocks($product->id)}}" >
                                        <button
                                            style="margin-top: 20px; width: 100%; box-sizing: border-box"
                                            class="primary-btn"
                                            type="submit">
                                            Add
                                        </button>
                                    </form>
                                </td>
                            @endforeach

                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="store-modal-body">
                <h2>From the other stores: </h2>

                @if(sizeof($key = \App\Product::getRelatedProduct(session()->get('key')[0])) > 0)
                    <table class="storemanagement-table" style="width: 100%; overflow-x: auto">
                        <thead>
                        <tr class="tr-header">
                            <th width="10%"></th>
                            @foreach($key as $product)
                                @if($product->store_id != session()->get('key')[0]['store_id'])
                                    <th>{{$product->name}}</th>
                                @endif
                            @endforeach
                        </tr>
                        </thead>
                        <tbody
                        style="width: 100%; overflow-x: auto"
                        >
                        <tr class="tr-data">
                            <td>Store Name</td>
                            @foreach($key as $product)
                                @if($product->store_id != session()->get('key')[0]['store_id'])
                                    <td><strong>{{$product->store->name}}</strong></td>
                                @endif
                            @endforeach
                        </tr>
                        <tr class="tr-data">
                            <td>Image</td>
                            @foreach($key as $product)
                                @if($product->store_id != session()->get('key')[0]['store_id'])
                                    <td align="center"><img src="/storage/product_images/{{$product->product_image}}" width="200px" height="120px"></td>
                                @endif
                            @endforeach
                        </tr>
{{--                        <tr class="tr-data">--}}
{{--                            <td>Description</td>--}}
{{--                            @foreach($key as $product)--}}
{{--                                @if($product->store_id != session()->get('key')[0]['store_id'])--}}
{{--                                    <td width="40%">{{$product->description}}</td>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </tr>--}}
{{--                        <tr class="tr-data">--}}
{{--                            <td>Brand</td>--}}
{{--                            @foreach($key as $product)--}}
{{--                                @if($product->store_id != session()->get('key')[0]['store_id'])--}}
{{--                                    <td>{{$product->brand->name}}</td>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </tr>--}}
                        <tr class="tr-data">
                            <td>Price</td>
                            @foreach($key as $product)
                                @if($product->store_id != session()->get('key')[0]['store_id'])
                                    <td>P <strong>{{number_format($product->selling_price) }}</td>
                                @endif
                            @endforeach
                        </tr>
                        <tr class="tr-data">
                            <td>Action</td>
                            @foreach($key as $product)
                                @if($product->store_id != session()->get('key')[0]['store_id'])
                                <td>
                                    <form method="post" action="{{ route('product.addtocart', ['id' => $product->id]) }}" style="text-align: center">
                                        @csrf
                                        <input type="text"
                                               name="qty"
                                               class="form-input"
                                               placeholder="Qty:{{$product->getStocks($product->id)}}" >
                                        <button type="submit"
                                                style="margin-top: 20px; width: 100%"
                                                class="primary-btn">
                                            Add
                                        </button>
                                    </form>
                                </td>
                                @endif
                            @endforeach

                        </tr>
                        </tbody>
                    </table>
                @else
                    No similar product has been found
                @endif
            </div>
            <div class="store-modal-footer">

            </div>
        </div>
    </div>
@endif
