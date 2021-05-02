<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QuickGrocery</title>
</head>
<body>
    <h1>Request for Supply</h1>
    <h3>Store Name: {{$details['storeName']}}</h3>
    <h3>Store Location: {{$details['storeLocation']}}</h3>
    <br>
    <h3>Product Name</h3>
        <p>{{$details['productName']}}</p>

    <h3>Product Description</h3>
        <p>{{$details['productDescription']}}</p>

    <h3>Product Brand</h3>
        <p>{{$details['productBrand']}}</p>

    <h3>Requested Stocks</h3>
        <p>{{$details['requestedStock']}}</p>

</body>
</html>
