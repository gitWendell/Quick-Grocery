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
        <h2><b>From:</b>{{$details['email']}} ({{$details['fullname']}})</h2>
        <i></i>
        <h2><b>Message</b></h2>
        <p>{{$details['message']}}</p>
    </div>

</body>
</html>
