@extends('systemadmin.inc.layout')

@section('sidebar-content')
<div class="systemadmin-content-header">
    <div class="header-title">
        <h1>Store Management</h1>
    </div>
</div>
<div class="systemadmin-content-body">
    <div class="row">
        <div class="column-registerstore">
            <button type="button" id="togglemodal-registerstore">Register Store</button>
        </div>
        <div class="column-searchstore">
            <input type="text" id="search_store" placeholder="Search ...">
            <button type="button">Submit</button>
        </div>
        <div class="column-reports">
            <a href="/system-admin/store/pdf" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a>
        </div>
    </div>
    @include('inc.messages')
    <table class="storemanagement-table" id="storeDatatable">
        <tr class="tr-header">
            <th>Store ID</th>
            <th>Email</th>
            <th>Store Name</th>
            <th>Location</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
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
                    <td id="status-{{$user->store->id}}">{{ $user->store->status }}</td>
                    <td><button id="toggleModal-updateStore" class="toggleModal-updateStore primary-btn">Update</button></td>
                </tr>
                @endempty
            @endforeach
        @endisset
    </table>

</div>
<div class="systemadmin-content-footer">
    {{$users->links()}}
</div>
@endsection
@section('scripts')
    <script class="reloadMe" src="{{ asset('js/systemadmin/store-modal.js') }}"></script>
    <script class="reloadMe" src="{{ asset('js/systemadmin/dashboard-controls.js') }}"></script>
@endsection
