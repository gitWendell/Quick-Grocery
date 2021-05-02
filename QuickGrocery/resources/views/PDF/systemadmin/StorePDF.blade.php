<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Store PDF</title>
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
        <h1>Store List</h1>
        <table class="storemanagement-table" id="storeDatatable">
            <tr class="tr-header">
                <th>ID</th>
                <th>Email</th>
                <th>Store Name</th>
                <th>Location</th>
                <th>Description</th>
                <th>Status</th>
                <th>Created On</th>
            </tr>
            <div style="display: none;">{{$count=1}}</div>
            @isset($users)
                @foreach ($users as $user)
                    @empty($user->store)

                    @else
                        <tr class="tr-data">
                            <td class="tr-data-id">{{ $user->store->id }}</td>
                            <td>{{ $user->email}}</td>
                            <td>{{ $user->store->name}}</td>
                            <td> {{ $user->store->cityF->citymunDesc}}, {{  $user->store->cityF->barangays()->find($user->store->barangay)->brgyDesc }}</td>
                            <td>{{ $user->store->description}}</td>
                            <td>{{ $user->store->status }}</td>
                            <td>{{ $user->store->created_at }}</td>
                        </tr>
                    @endempty
                @endforeach
            @endisset
        </table>
    </div>
<div class="page-break"></div>
<div>
    <h1>Active Store List</h1>
    <table class="storemanagement-table" id="storeDatatable">
        <tr class="tr-header">
            <th>ID</th>
            <th>Email</th>
            <th>Store Name</th>
            <th>Location</th>
            <th>Description</th>
            <th>Status</th>
            <th>Created On</th>
        </tr>
        <div style="display: none;">{{$count=1}}</div>
        @isset($users)
            @foreach ($users as $user)
                @empty($user->store)

                @else
                    @if($user->store->status == 'Active')
                    <tr class="tr-data">
                        <td class="tr-data-id">{{ $user->store->id }}</td>
                        <td>{{ $user->email}}</td>
                        <td>{{ $user->store->name}}</td>
                        <td> {{ $user->store->cityF->citymunDesc}}, {{  $user->store->cityF->barangays()->find($user->store->barangay)->brgyDesc }}</td>
                        <td>{{ $user->store->description}}</td>
                        <td>{{ $user->store->status }}</td>
                        <td>{{ $user->store->created_at }}</td>
                    </tr>
                    @endif
                @endempty
            @endforeach
        @endisset
    </table>
</div>
<div class="page-break"></div>
<div>
    <h1>Blocked Store List</h1>
    <table class="storemanagement-table" id="storeDatatable">
        <tr class="tr-header">
            <th>ID</th>
            <th>Email</th>
            <th>Store Name</th>
            <th>Location</th>
            <th>Description</th>
            <th>Status</th>
        </tr>
        <div style="display: none;">{{$count=1}}</div>
        @isset($users)
            @foreach ($users as $user)
                @empty($user->store)

                @else
                    @if($user->store->status == 'Block')
                        <tr class="tr-data">
                            <td class="tr-data-id">{{ $user->store->id }}</td>
                            <td>{{ $user->email}}</td>
                            <td>{{ $user->store->name}}</td>
                            <td> {{ $user->store->cityF->citymunDesc}}, {{  $user->store->cityF->barangays()->find($user->store->barangay)->brgyDesc }}</td>
                            <td>{{ $user->store->description}}</td>
                            <td>{{ $user->store->status }}</td>
                        </tr>
                    @endif
                @endempty
            @endforeach
        @endisset
    </table>
</div>
</body>

</html>
