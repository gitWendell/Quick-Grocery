@extends('customer.inc.layout')

@section('user-account-content')
    <div class="user-dashboard-content">
        <div class="user-dashboard-content-title">
            <div> Reusable Cart </div>
        </div>
        <div class="customer-dashboard-body" id="reusable-table">
            @include('inc.messages')
            <table class="customer-address" >
                <tr class="tr-header">
                    <th width="10%">Id</th>
                    <th width="40%">Items x Qty</th>
                    <th width="15%">Total</th>
                    <th width="10%">Status</th>
                    <th width="25%">Action</th>
                </tr>
                @isset($reusable_carts)
                    @foreach($reusable_carts as $reusable_cart)
                        <tr class="tr-data">
                            <td class="tr-data-id">{{$reusable_cart->id}} </td>
                            @if(sizeof($reusable_cart->reusablecarts) > 1)
                                <td>@foreach($reusable_cart->reusablecarts as $cartdetail){{$cartdetail->product->name}} x {{$cartdetail->qty}}, &nbsp;@php $total = $total + ($cartdetail->qty * number_format($cartdetail->product->price, 2));@endphp
                                    @endforeach</td>
                                <td>P {{number_format($total, 2)}}</td>
                            @else
                                <td>{{$reusable_cart->reusablecarts->first()->product->name}} x {{$reusable_cart->reusablecarts->first()->qty}}</td>
                                <td>P {{number_format($reusable_cart->reusablecarts->first()->qty * $reusable_cart->reusablecarts->first()->product->price, 2)}}</td>
                            @endif
                            <td style="text-align: center">{{$reusable_cart->status}}</td>
                            <td style="text-align: center">
                                <button
                                    type="button"
                                    data-id="{{$reusable_cart->id}}"
                                    class="toggleModal-update-reusableCart primary-btn">
                                    Update
                                </button>
                                <a class="td-link success-btn reusable-id"
                                   data-id="{{$reusable_cart->id}}"
                                   type="button"
                                   href="/reusable/addtocart/{{$reusable_cart->id}}"> Add to Cart</a>

                                <a class="td-link danger-btn reusable-delete-id"
                                   data-id="{{$reusable_cart->id}}"
                                   type="button"
                                   href="/reusable/delete/{{$reusable_cart->id}}">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </table>
        </div>
    </div>

    @section('scripts')
        <script src="{{ asset('js/customer/reusable.js') }}"></script>
    @endsection
@endsection
