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
    <div class="container">
        Hello {{ $details['name'] }}<br><br>
        Please activate your account using the following link<br><br>
        ---<br>
        <a class="primary-btn" href="{{$details['links']}}">Click To Verify</a><br>
    </div>
</body>
</html>
