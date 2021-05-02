@extends('customer.inc.layout')

@section('user-account-content')
    <div class="user-dashboard-content">
        <div class="user-dashboard-content-title">
            <div> Order Details </div>
        </div>
        <div class="customer-dashboard-body" id="reusable-table">
            <h4>Order ID: <strong>{{$order_master->id}}</strong></h4>
            <h4>Order On: <strong>{{$order_master->created_at}}</strong></h4>
            <h4>Order Status: <strong>{{$order_master->status}}</strong></h4>
            <h4>Store Ordered: <strong>{{$order_master->store->name}}</strong></h4>

            <h2>Order List</h2>
            <table id="customer-address-id" class="customer-address" >
                <tr class="tr-header">
                    <th>Id</th>
                    <th width="150px">Image</th>
                    <th>Item x Qty</th>
                    <th>Total</th>
                </tr>
                @isset($order_master)
                    @foreach($order_master->orderdetails as $order_detail)
                        <tr>
                            <td>{{$order_detail->id}}</td>
                            <td><img src="/storage/product_images/{{$order_detail->product->product_image}}" width="100%" height="50px"> </td>
                            <td>({{$order_detail->product->name}} x {{$order_detail->qty}}, 2)</td>
                            <td>P {{number_format($order_detail->product->price * $order_detail->qty, 2)}}</td>
                        </tr>
                    @endforeach
                @endisset
            </table>
            <h4>Total: <strong>P {{number_format($order_master->total($order_master->id), 2)}}</strong></h4>
        </div>
    </div>
@endsection
