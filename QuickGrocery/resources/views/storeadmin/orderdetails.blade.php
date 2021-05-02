@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Order Details</h1>
        </div>
    </div>
    <div class="store-content-body">
        @include('inc.messages')
        <div class="column-reports" style="float: right">
            <a href="/storeadmin/ordermanagement/view/report/{{$order_master->id}}" style="text-decoration: none" target="_blank">
                <i class="fa fa-file" aria-hidden="true"></i>
                Generate
            </a>
        </div>
        <div class="container">
            <div class="customer-dashboard-body" id="reusable-table">
                <h4>Order ID: <strong>{{$order_master->id}}</strong></h4>
                <h4>Order On: <strong>{{$order_master->created_at}}</strong></h4>
                <h4>Order Status: <strong>{{$order_master->status}}</strong></h4>
                <h4>Mode of Payment:
                    <strong>
                        @if($order_master->method == 2)
                            Pick up
                        @else

                        @endif
                    </strong>
                </h4>
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
                                <td>({{$order_detail->product->name}} x {{$order_detail->qty}})</td>
                                <td>P {{number_format($order_detail->product->price * $order_detail->qty, 2)}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <span style="float: right">Total: </span>
                            </td>
                            <td>P {{number_format($order_master->total($order_master->id), 2)}}</td>
                        </tr>
                    @endisset
                </table>

                <h2>Buyer</h2>
                <div class="row" style="margin:0 0 20px 0;">
                    <div class="buyer-information" style="width: 100%; padding: 10px;">
                        <h3 style="background: #ff7955;color: white; padding: 10px;">Buyer Information</h3>
                        <div style="border: 2px solid black; margin-top: -9px; padding: 10px">
                            <div class="row" style="margin: 0">
                                <div style="width: 50%">
                                    <h2>Customer</h2>
                                    <h4>Name</h4>
                                    <h4><strong>{{$order_master->users->name}}</strong></h4>
                                    <h4>Email</h4>
                                    <h4><strong>{{$order_master->users->email}}</strong></h4>
                                </div>
                                <div style="width: 50%">
                                    <h2>Address</h2>
                                    @if($order_master->billing == null)

                                    @else
                                        <h4>Full Name</h4>
                                        <h4><strong>{{$order_master->billing_address->fullname}}</strong></h4>
                                        <h4>Mobile number</h4>
                                        <h4><strong>{{$order_master->billing_address->mobilenumber}}</strong></h4>
                                        <h4>Notes</h4>
                                        <h4><strong>{{$order_master->billing_address->notes}}</strong></h4>
                                        <h4>Complete Address</h4>
                                        <h4>
                                            <strong>
                                                {{$order_master->billing_address->city->citymunDesc}}, {{$order_master->billing_address->completeaddress}}
                                            </strong>
                                        </h4>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="store-content-footer">

    </div>
@endsection
