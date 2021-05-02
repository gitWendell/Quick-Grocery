@extends('layouts.app')
@php
    $innerHeader = 'Checkout';
    $innerHeaderPara = 'Home / Checkout';
@endphp

@include('inc/inner-header')


@section('content')
    <div class="container checkout-container">
        <div class="checkout-header">
            <h3>Your Order</h3>
        </div>
        @include('inc.messages')
        <div class="checkout-body">
            <table class="checkout-table">
                <tr>
                    <th width="5%" style="text-align:center;">Store Id</th>
                    <th width="50%">Product</th>
                    <th width="35%"><strong>Subtotal</strong></th>
                </tr>
                @isset($cartitems)
                    @foreach ($cartitems as $cartitem)
                    <tr>
                        <td>{{ $cartitem->product->store_id }}</td>
                        <td> {{ $cartitem->product->name }} P {{ number_format($cartitem->product->price, 2)}} x {{ $cartitem->qty }}</td>
                        <td>P {{number_format(($cartitem->product->price)*$cartitem->qty, 2)}} </td>
                    </tr>
                    @endforeach
                    <tfoot class="checkout-table-footer">
                        <tr>
                            <th></th>
                            <th>Subtotal</th>
                            <td>P {{ number_format($subtotal, 2) }} </td>
                        </tr>

                        @if(session()->has('shipping'))
                            <tr>
                                <th></th>
                                <th id="shipping-text">Shipping ( <i>Distance: {{session()->get('shipping')['distance']}} km</i> )</th>
                                <td>P {{number_format(session()->get('shipping')['amount'], 2)}}</td>
                            </tr>
                        @endif

                        @if(session()->has('coupon'))
                            <tr>
                                <th></th>
                                <th>Coupon ({{session()->get('coupon')['code']}}) <a href="/removeCouponCode" class="td-link">Remove</a></th>
                                <td>P -{{number_format(session()->get('coupon')['discount'], 2)}}</td>
                            </tr>
                        @endif
                        <tr>
                            <th></th>
                            <th>Total</th>
                            <td>P {{ number_format(($subtotal+session()->get('shipping')['amount']) - session()->get('coupon')['discount'], 2) }} </td>
                        </tr>
                    </tfoot>
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tfoot class="checkout-table-footer">
                        <td></td>
                        <th>Subtotal</th>
                        <td></td>
                        <th>Shipping</th>
                        <td>P 0.00</td>
                        <th>Total</th>
                        <td></td>
                    </tfoot>

                @endisset
            </table>
            <div id="response"></div>
            <div class="available-coupons">
                <h3>Available Coupons</h3>
                    <div class="available-coupons-content">
                    @php
                        $rewards = new \App\Reward()
                    @endphp
                    @if($rewards->getAvailableReward()->count() <= 0 )
                        <h2 style="text-align: center; margin-top: 50px">
                            No available coupons
                        </h2>
                    @else
                        <div class="row" style="margin: 0">
                            @foreach($rewards->getAvailableReward() as $reward)
                                <div class="available-coupon">
                                    <div class="available-coupons-code">
                                        <p>CODE: </p>
                                        <h3>{{$reward->code}} P {{$reward->discount}}</h3>
                                    </div>
                                    <div class="expiration-date">
                                        <span>Until: {{$reward->endDate}}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            @if(!session()->has('coupon'))
                <div class="checkout-coupon">
                    <h3>Coupon Code</h3>
                    <form action="/applyCouponCode" method="POST">
                        @csrf
                        <input type="text" class="form-input" name="coupon" style="width: 30% !important;">
                        <button type="submit">Apply Coupon</button>
                    </form>
                </div>
            @endif
            <form method="POST" action="/checkout/{{Auth::id()}} ">
                @csrf
                <div class="row" style="margin: 0px">
                    <div class="checkout-billing">
                        <h3>Billing Address</h3>
                        @if($billings->isEmpty())
                            <div class="billing-options">
                                <a href="/customer/addresses">Add Billing Address Here</a>
                            </div>
                        @else
                            @foreach ($billings as $billing)
                                <div class="billing-options">
                                    <input type="radio" name="billing" value="{{$billing->id}}">{{$billing->city->citymunDesc}} - {{$billing->city->barangays()->find($billing->barangay_id)->brgyDesc}}
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="checkout-payment-method">
                        <h3>Payment Method</h3>
                        @isset($cartitems)
                            @foreach ($cartitems as $key => $cartitem)
                                @if($dupes != $cartitem->product->store_id)
                                    {{$cartitem->product->store()->first()->name}}
                                    @if ($cartitem->product->store()->find($cartitem->product->store_id)->candeliver == 0)
                                        <div class="row" style="margin:0;">
                                            <div class="billing-options-disabled" style="width: 30%">
                                                <input type="radio" name="method[{{$cartitem->product->store_id}}]" value="1" disabled> Cash on Delivery
                                            </div>
                                            <div class="billing-options" style="width: 30%">
                                                <input type="radio" name="method[{{$cartitem->product->store_id}}]" value="2" checked="checked" required> Pick Up
                                            </div>
                                        </div>
                                    @else
                                        <div class="row" style="margin:0;">
                                            <div class="billing-options" style="width: 30%">
                                                <input type="radio" class="method-selected" data-id="{{$cartitem->product->store_id}}"
                                                       name="method[{{$cartitem->product->store_id}}]"
                                                       value="1" required> Cash on Delivery
                                            </div>
                                            <div class="billing-options" style="width: 30%">
                                                <input type="radio" class="method-selected"
                                                       name="method[{{$cartitem->product->store_id}}]"
                                                       value="2"> Pick Up
                                            </div>
                                        </div>
                                    @endif
                                @php ($dupes = $cartitem->product->store_id) @endphp
                                @endif
                            @endforeach
                        @endisset
                    </div>
                    <div class="checkout-footer">
                        <button type="submit" id="place-order" class="checkout-button">Place Order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/customer/checkout.js') }}"></script>
@endsection
