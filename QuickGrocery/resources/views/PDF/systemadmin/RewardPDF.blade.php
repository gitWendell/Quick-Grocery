<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reward PDF</title>
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
        <h1>Reward List</h1>
        <table class="storemanagement-table" id="storeDatatable">
            <tr class="tr-header">
                <th width="10%">ID</th>
                <th width="20%">Code</th>
                <th width="20%">Start Date</th>
                <th width="20%">End Date</th>
                <th width="15%">Status</th>
                <th width="15%">Created On</th>
            </tr>
            @isset($rewards)
                @foreach($rewards as $reward)
                    <tr class="tr-data">
                        <td>{{$reward->id}}</td>
                        <td>{{$reward->code}}</td>
                        <td>{{$reward->startDate}}</td>
                        <td>{{$reward->endDate}}</td>
                        <td>{{$reward->status}}</td>
                        <td>{{$reward->created_at}}</td>
                    </tr>
                @endforeach
            @endisset
        </table>
    </div>
<div class="page-break"></div>
    <div>
        <h1>Used Reward List</h1>
        <table class="storemanagement-table" id="storeDatatable">
            <tr class="tr-header">
                <th width="10%">ID</th>
                <th width="20%">Code</th>
                <th width="20%">Start Date</th>
                <th width="20%">End Date</th>
                <th width="15%">Create On</th>
            </tr>
            @isset($rewards)
                @foreach($rewards as $reward)
                    @if($reward->status == 'Used')
                        <tr class="tr-data">
                            <td>{{$reward->id}}</td>
                            <td>{{$reward->code}}</td>
                            <td>{{$reward->startDate}}</td>
                            <td>{{$reward->endDate}}</td>
                            <td>{{$reward->created_at}}</td>
                        </tr>
                    @endif
                @endforeach
            @endisset
        </table>
    </div>
<div class="page-break"></div>
<div>
    <h1>Expired Reward List</h1>
    <table class="storemanagement-table" id="storeDatatable">
        <tr class="tr-header">
            <th width="10%">ID</th>
            <th width="20%">Code</th>
            <th width="20%">Start Date</th>
            <th width="20%">End Date</th>
            <th width="15%">Created On</th>
        </tr>
        @isset($rewards)
            @foreach($rewards as $reward)
                @if($reward->endDate < date('Y-m-d '))
                    <tr class="tr-data">
                        <td>{{$reward->id}}</td>
                        <td>{{$reward->code}}</td>
                        <td>{{$reward->startDate}}</td>
                        <td>{{$reward->endDate}}</td>
                        <td>{{$reward->created_at}}</td>
                    </tr>
                @endif
            @endforeach
        @endisset
    </table>
</div>
</body>

</html>
