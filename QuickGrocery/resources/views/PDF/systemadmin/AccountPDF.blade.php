<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account PDF</title>
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
        <h1>All Accounts</h1>
        <table class="storemanagement-table" id="storeDatatable">
            <tr class="tr-header">
                <th>ID</th>
                <th>Display Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created On</th>
                <th>Last Update</th>
            </tr>
            <div style="display: none;">{{$count=1}}</div>
            @isset($users)
                @foreach ($users as $user)
                    @if ($user->role != 'systemadmin')
                        <tr class="tr-data">
                            <td class="tr-data-id">{{ $user->id }}</td>
                            <td>{{ $user->name}}</td>
                            <td>{{ $user->email}}</td>
                            <td>{{ $user->role}}</td>
                            <td>{{ $user->status}}</td>
                            <td>{{ $user->created_at}}</td>
                            <td>{{ $user->updated_at}}</td>
                        </tr>
                    @endif
                @endforeach
            @endisset
        </table>
    </div>
<div class="page-break"></div>
<div>
    <h1>Customers Account</h1>
    <table class="storemanagement-table" id="storeDatatable">
        <tr class="tr-header">
            <th>ID</th>
            <th>Display Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created On</th>
            <th>Last Update</th>
        </tr>
        <div style="display: none;">{{$count=1}}</div>
        @isset($users)
            @foreach ($users as $user)
                @if ($user->role == 'customer')
                    <tr class="tr-data">
                        <td class="tr-data-id">{{ $user->id }}</td>
                        <td>{{ $user->name}}</td>
                        <td>{{ $user->email}}</td>
                        <td>{{ $user->role}}</td>
                        <td>{{ $user->status}}</td>
                        <td>{{ $user->created_at}}</td>
                        <td>{{ $user->updated_at}}</td>
                    </tr>
                @endif
            @endforeach
        @endisset
    </table>
</div>

<div class="page-break"></div>
<div>
    <h1>Store Admin Account</h1>
    <table class="storemanagement-table" id="storeDatatable">
        <tr class="tr-header">
            <th>ID</th>
            <th>Display Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created On</th>
            <th>Last Update</th>
        </tr>
        <div style="display: none;">{{$count=1}}</div>
        @isset($users)
            @foreach ($users as $user)
                @if ($user->role == 'storeadmin')
                    <tr class="tr-data">
                        <td class="tr-data-id">{{ $user->id }}</td>
                        <td>{{ $user->name}}</td>
                        <td>{{ $user->email}}</td>
                        <td>{{ $user->role}}</td>
                        <td>{{ $user->status}}</td>
                        <td>{{ $user->created_at}}</td>
                        <td>{{ $user->updated_at}}</td>
                    </tr>
                @endif
            @endforeach
        @endisset
    </table>
</div>

<div class="page-break"></div>
<div>
    <h1>Staffs Account</h1>
    <table class="storemanagement-table" id="storeDatatable">
        <tr class="tr-header">
            <th>ID</th>
            <th>Display Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created On</th>
            <th>Last Update</th>
        </tr>
        <div style="display: none;">{{$count=1}}</div>
        @isset($users)
            @foreach ($users as $user)
                @if ($user->role == 'staff')
                    <tr class="tr-data">
                        <td class="tr-data-id">{{ $user->id }}</td>
                        <td>{{ $user->name}}</td>
                        <td>{{ $user->email}}</td>
                        <td>{{ $user->role}}</td>
                        <td>{{ $user->status}}</td>
                        <td>{{ $user->created_at}}</td>
                        <td>{{ $user->updated_at}}</td>
                    </tr>
                @endif
            @endforeach
        @endisset
    </table>
</div>
</body>

</html>
