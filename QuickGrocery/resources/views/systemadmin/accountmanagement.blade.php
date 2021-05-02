@extends('systemadmin.inc.layout')

@section('sidebar-content')
<div class="systemadmin-content-header">
    <div class="header-title">
        <h1>Account Management</h1>
    </div>
</div>
<div class="systemadmin-content-body">
    <div class="row">
        <div class="column-registerstore">
        </div>
        <div class="column-searchstore">
            <input type="text" id="search_account" placeholder="Search ...">
            <button type="button">Submit</button>
        </div>
        <div class="column-reports">
            <a href="/system-admin/account/pdf" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a>
        </div>
    </div>

    @include('inc.messages')
    <table class="storemanagement-table" id="storeDatatable">
        <tr class="tr-header">
            <th>ID</th>
            <th>Display Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Action</th>
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
                        <td><button id="toggleModal-updateAccount" class="toggleModal-updateAccount">Update</button></td>
                    </tr>
                @endif
            @endforeach
        @endisset
    </table>

</div>
<div class="systemadmin-content-footer">
    {{$users->links()}}
</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/systemadmin/account-list-asset/account.js') }}"></script>
    <script src="{{ asset('js/systemadmin/dashboard-controls.js') }}"></script>
@endsection
