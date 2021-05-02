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
        <h1>Expenses</h1>
        <table class="storemanagement-table" id="storeDatatable">
            <tr class="tr-header">
                <th width="10%">ID				</th>
                <th width="20%">ITEMS X QTY</th>
                <th width="20%">TOTAL</th>
                <th width="20%">PLACE ON</th>
                <th width="15%">STATUS</th>
            </tr>
            @isset($orders)
                @foreach($orders as $ordermaster)
                    @if($ordermaster->status == 'Pending' || $ordermaster->status == 'Packaging' || $ordermaster->status == 'Ready')
                    @else

                    <tr class="tr-data">
                        <td class="tr-data-id">{{$ordermaster->id}} </td>
                        <td>{{$ordermaster->items($ordermaster->id)}}</td>
                        <td>P {{number_format($ordermaster->total, 2)}}</td>
                        <td>{{$ordermaster->created_at}}</td>
                        <td>{{$ordermaster->status}}</td>
                    </tr>
                    @endif
                @endforeach
            @endisset
        </table>
    </div>

</body>

</html>
