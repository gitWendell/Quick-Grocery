<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventory PDF</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <style>
        .page-break {
            page-break-after: always;
        }
        @page { margin: 5px; }
    </style>
</head>

<body>
<div style="margin-left: 10%; width: 80%;">
    <img src="{{asset('images/logos.png')}}" alt="" width="100%" height="50px">
</div>
    <div>
        <h1>Inventory List</h1>
        <table class="storemanagement-table" id="storeDatatable">
            <tr class="tr-header">
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Band</th>
                <th>Category</th>
                <th>Created On</th>

            </tr>
            <div style="display: none;">{{$count=1}}</div>
            @isset($store)
                @foreach ($store->products as $product)
                    <tr class="tr-data">
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->description}}</td>
                        <td>{{$product->brand->name}}</td>
                        <td>{{$product->subcategory->name}}</td>
                        <td>{{$product->created_at}}</td>
                    </tr>
                @endforeach
            @endisset
        </table>
    </div>
<div class="page-break"></div>
<div>
    <h1>Stocks List</h1>
    <table class="storemanagement-table" id="storeDatatable">
        <tr class="tr-header">
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Stock</th>
            <th>Original Price</th>
            <th>Profit</th>
        </tr>
        <div style="display: none;">{{$count=1}}</div>
        @isset($store)
            @foreach ($store->products as $product)
                <tr class="tr-data">
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->description}}</td>
                    <td class="tr-data-action">{{$product->getStocks($product->id)}}</td>
                    <td class="tr-data-action">P {{ number_format($product->origprice, 2) }}</td>
                    <td class="tr-data-action">P {{ number_format($product->profit, 2) }}</td>
                </tr>
            @endforeach
        @endisset
    </table>
</div>

<div class="page-break"></div>
<div>
    <h1>Requested Stocks List</h1>
    <table class="storemanagement-table" id="storeDatatable">
        <tr class="tr-header">
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Requested Stock</th>
            <th>Supplier Name</th>
            <th>Status</th>
        </tr>
        <div style="display: none;">{{$count=1}}</div>
    </table>
</div>
</body>

</html>
