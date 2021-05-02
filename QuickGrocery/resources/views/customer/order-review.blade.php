@extends('customer.inc.layout')

@section('user-account-content')
    <div class="user-dashboard-content">
        <div class="user-dashboard-content-title">
            <div> Review Order </div>
        </div>
        <div class="customer-dashboard-body">
            @include('inc.messages')
            <form action="/customer/review/post/{{$orderDetails->first()->order_id}}" method="post">
                @csrf

                <h1>Order Id: <strong>{{$orderDetails->first()->order_id}}</strong></h1>
                <h3>Place On: <strong>{{$orderDetails->first()->created_at}}</strong></h3>
                <div class="customer-review-area">
                    @foreach($orderDetails as $orderDetail)
                        <h4>{{$orderDetail->product->name}} x {{$orderDetail->qty}}</h4>
                        <input type="text" name="product_id[]" value="{{$orderDetail->product->id}}" hidden>

                        <label for="comment">Your rating</label>
                        <select name="stars[]">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select><br/>
                        <label for="comment">Comment</label>
                        <textarea class="form-textarea" name="comment[]" cols="30" rows="3"></textarea>
                    @endforeach
                </div>
                <div class="button-add-brand">
                    <button type="submit" class="addbrandButton">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
@endsection
