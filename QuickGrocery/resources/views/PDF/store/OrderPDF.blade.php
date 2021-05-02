<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expenses PDF</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <style>
        .page-break {
            page-break-after: always;
        }
        @page { margin: 5px; }
    </style>
</head>

<body>
<div style="margin-left: 20%; width: 80%;">
    <img src="{{asset('images/logos.png')}}" alt="" style="margin-left: 5%" width="60%" height="50px">
</div>
    <div>
        <h1>Order Reports</h1>
        <table class="storemanagement-table staffviews" id="storeDatatable">
            <tr class="tr-header">
                <th>Id</th>
                <th>Name</th>
                <th>Items x Qty</th>
                <th>Total</th>
                <th>Method</th>
                <th>Billing Address</th>
                <th>Status</th>
            </tr>
            @isset($orders)
                @foreach($orders as $ordermaster)
                    <tr class="tr-data">
                        <td class="tr-data-id">{{$ordermaster->id}} </td>
                        <td class="tr-data-id">{{$ordermaster->users->name}} </td>
                        <td>{{$ordermaster->items($ordermaster->id)}}</td>
                        <td>P {{number_format($ordermaster->total, 2)}}</td>
                        <td>{{($ordermaster->method == 2) ? 'Pickup' : 'Deliver' }}</td>
                        <td>{{($ordermaster->billing == '') ? 'No Billing Address' : $ordermaster->billing_address->city->citymunDesc. ', '.  $ordermaster->billing_address->barangay->brgyDesc}}</td>
                        <td>{{$ordermaster->status}}</td>
                    </tr>
                @endforeach
            @endisset
        </table>
    </div>
<div class="page-break"></div>
<div>
    <h1>Order Cancel</h1>
    <table class="storemanagement-table staffviews" id="storeDatatable">
        <tr class="tr-header">
            <th>Id</th>
            <th>Name</th>
            <th>Items x Qty</th>
            <th>Total</th>
            <th>Method</th>
            <th>Billing Address</th>
            <th>Status</th>
        </tr>
        @isset($orders)
            @foreach($orders as $ordermaster)
                @if($ordermaster->status == 'Cancel')
                    <tr class="tr-data">
                        <td class="tr-data-id">{{$ordermaster->id}} </td>
                        <td class="tr-data-id">{{$ordermaster->users->name}} </td>
                        <td>{{$ordermaster->items($ordermaster->id)}}</td>
                        <td>P {{number_format($ordermaster->total, 2)}}</td>
                        <td>{{($ordermaster->method == 2) ? 'Pickup' : 'Deliver' }}</td>
                        <td>{{($ordermaster->billing == '') ? 'No Billing Address' : $ordermaster->billing_address->city->citymunDesc. ', '.  $ordermaster->billing_address->barangay->brgyDesc}}</td>
                        <td>{{$ordermaster->status}}</td>
                    </tr>
                @endif
            @endforeach
        @endisset
    </table>
</div>

<div class="page-break"></div>
<div>
    <h1>Order Pending</h1>
    <table class="storemanagement-table staffviews" id="storeDatatable">
        <tr class="tr-header">
            <th>Id</th>
            <th>Name</th>
            <th>Items x Qty</th>
            <th>Total</th>
            <th>Method</th>
            <th>Billing Address</th>
            <th>Status</th>
        </tr>
        @isset($orders)
            @foreach($orders as $ordermaster)
                @if($ordermaster->status == 'Pending')
                    <tr class="tr-data">
                        <td class="tr-data-id">{{$ordermaster->id}} </td>
                        <td class="tr-data-id">{{$ordermaster->users->name}} </td>
                        <td>{{$ordermaster->items($ordermaster->id)}}</td>
                        <td>P {{number_format($ordermaster->total, 2)}}</td>
                        <td>{{($ordermaster->method == 2) ? 'Pickup' : 'Deliver' }}</td>
                        <td>{{($ordermaster->billing == '') ? 'No Billing Address' : $ordermaster->billing_address->city->citymunDesc. ', '.  $ordermaster->billing_address->barangay->brgyDesc}}</td>
                        <td>{{$ordermaster->status}}</td>
                    </tr>
                @endif
            @endforeach
        @endisset
    </table>
</div>

<div class="page-break"></div>
<div>
    <h1>Sales Report</h1>
    <table class="storemanagement-table staffviews" id="storeDatatable">
        <tr class="tr-header">
            <th>Id</th>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Supplier Price</th>
            <th>Selling Price</th>
            <th>Profit</th>
            <th>Date On</th>
        </tr>
        @isset($orders)
            @foreach($orders as $ordermaster)
                @foreach($ordermaster->orderdetails as $orderdetail)
                    <tr class="tr-data">
                        <td>{{$orderdetail->id}}</td>
                        <td>{{$orderdetail->product->name}}</td>
                        <td>{{$orderdetail->qty}}</td>
                        <td>P {{number_format($orderdetail->product->price, 2)}}</td>
                        <td>P {{number_format($orderdetail->selling_price, 2)}}</td>
                        <td>P {{number_format($orderdetail->getProfit($orderdetail->id) * $orderdetail->qty, 2)}}</td>
                        <td>{{$orderdetail->created_at}}</td>
                    </tr>
                @endforeach
            @endforeach
                <tr class="tr-data">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total Profit:</td>
                    <td>P {{number_format(\App\Store::getTotalProfit(), 2)}}</td>
                </tr>
        @endisset
    </table>
</div>
</body>

</html>
