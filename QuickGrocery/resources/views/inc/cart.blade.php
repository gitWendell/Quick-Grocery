<div class="cart-modal">
    @if (Auth::id())
        <div class="cart-modal-header">
            <span class="cart-modal-header-title">My Cart (<span id="cart-qty">{{ Auth::user()->cart->sum('qty') }}</span> items) </span>
            <span><label for="openCart" class="fa fa-times cart-modal-header-close"></label></span>
        </div>
        @isset($cartitems)
            <div class="cart-modal-content">
                @foreach ($cartitems as $cartitem)
                    @if($dupes != $cartitem->product->store_id)
                        <div class="cart-content-store-name" id="ccsn-{{$cartitem->product->store->id}}">
                            <p>{{ $cartitem->product->store->name }}
                                <strong style="float: right" id="store-total-{{$cartitem->product->store->id}}">
                                    ₱ {{ $cartitem->getStoreTotal($cartitems) }}
                                </strong>
                            </p>
                        </div>
                        <div id="cm-{{$cartitem->product->store->id}}"></div>
                        @if($cartitem->getStoreTotal($cartitems) < 500)
                        <div id="cmm-{{$cartitem->product->store->id}}" class="cart-minimum-message">
                            <strong id="lacking-{{$cartitem->product->store->id}}">Add ₱ {{500 - $cartitem->getStoreTotal($cartitems)}}</strong> to reach minimum order.
                        </div>
                        @endif
                        @php ($dupes = $cartitem->product->store_id) @endphp
                    @endif
                    <ul class="cart-modal-content-ul">
                        <div id="cart-details-{{$cartitem->id}}">
                            <li class="cart-modal-content-li">
                                <div class="row" style="margin: 0px;">
                                    <div class="cart-content-img">
                                        <img src="/storage/product_images/{{$cartitem->product->product_image}}" width="200px" height="100px">
                                    </div>
                                    <div class="cart-content-info">
                                        <h5 class="cart-content-info-name">{{$cartitem->product->name}} </h5>
                                        <p class="cart-content-info-attributes">Attribute</p>
                                        <div style="float: right" class="cart-content-info-attributes">
                                            <form id="disabled-me" action="#" method="POST">
                                                @csrf
                                                <button type="button" class="cart-qty-reduce" id="cart-qty-reduce"
                                                        data-id="{{$cartitem->id}}"
                                                        data-store="{{$cartitem->product->store->id}}"
                                                        data-qty="{{$cartitem->qty}}">
                                                    -
                                                </button>

                                                <input  class="cart-qty-input" id="cart-qty-input-{{$cartitem->id}}"
                                                        data-id="{{$cartitem->id}}"
                                                        data-store="{{$cartitem->product->store->id}}"
                                                        type="number" value="{{ $cartitem->qty }}">

                                                <button type="button" class="cart-qty-increase" id="cart-qty-increase"
                                                        data-id="{{$cartitem->id}}"
                                                        data-store="{{$cartitem->product->store->id}}"
                                                        data-qty="{{$cartitem->qty}}"> + </button>
                                            </form>
                                        </div>
                                        <p class="cart-content-info-price"> <strong id="qty-details-{{$cartitem->id}}">{{ $cartitem->qty }}</strong>  x P {{ number_format($cartitem->product->price, 2) }}</p>
                                    </div>
                                </div>
                            </li>
                        </div>
                    </ul>
                @endforeach
            </div>
            <div class="cart-modal-footer">
                <div class="cart-modal-totalprice">
                    <p>Subtotal: <strong style="float: right;" id="cart-subtotal">P {{$subtotal}}</strong></p>
                </div>
                <div class="cart-modal-buttons">
                    <a class="modal-footer-button" id="cart-reusable" href="/cart/savetoreusablecart"> Add to Reusable Cart</a>
                    @if(Auth::user()->cartAvailable())
                        <a class="modal-footer-button" href="/checkout" id="cart-checkout"> Checkout</a>
                    @else
                        <a class="modal-footer-button not-avail" href="#" id="cart-checkout"> Checkout</a>
                    @endif

                </div>
            </div>
        @endisset
    @else
        <div class="cart-modal-header">
            <span class="cart-modal-header-title">My Cart (0 items) </span>
            <span><label for="openCart" class="fa fa-times cart-modal-header-close"></label></span>
        </div>
        <div class="cart-modal-content">
            <p>No Product in the Cart</p>
        </div>
    @endif
</div>
