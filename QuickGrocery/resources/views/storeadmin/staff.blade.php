@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Staff Management</h1>
        </div>
    </div>
    <div class="store-content-body">
        <div class="row">
            <div class="column-registerproduct">
            </div>
            <div class="column-searchproduct">
                <input type="text" placeholder="Search ...">
                <button type="button">Submit</button>
            </div>
            <div class="column-reports">
                <button type="button"><i class="fa fa-file" aria-hidden="true"></i></button>
            </div>
        </div>
        @include('inc.messages')
        <table class="storemanagement-table staffviews" id="storeDatatable">
            <tr class="tr-header">
                <th>ID</th>
                <th>Email</th>
                <th width="60%">Permission</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <div style="display: none;">{{$count=1}}</div>
            @isset($staffs)
                @foreach ($users as $user)
                    @foreach ($staffs as $staff)
                        @foreach ($stores as $store)
                            @if ($user->id == $staff->user_id)
                                @if ($staff->store_id == $store->id)
                                    <tr class="tr-data">
                                        <td class="tr-data-id">{{$staff->id}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>@foreach (explode(',', $staff->permissions) as $permissionExp)<div class="permission">@if (strpos($permissionExp, '2') !== false){!! str_replace('2', 'OrderM', $permissionExp) !!}@else {!! str_replace('1', 'InventoryM', $permissionExp)!!}@endif</div>@endforeach</td>
                                        <td>{{$staff->status}}</td>
                                        <td class="tr-data-action">
                                            <button type="button" class="toggleModal-updateStaff primary-btn">
                                                Update
                                            </button>
                                            <a href="/storeadmin/staffmanagement/delete/{{$staff->id}}"
                                               class="danger-btn td-link delete-staff">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @else

                                @endif
                            @endif
                        @endforeach
                    @endforeach
                @endforeach

            @endisset
        </table>
    </div>
    <div class="store-content-footer">

    </div>
    @section('scripts')
        <script src="{{ asset('js/storeadmin/staff-list-assets/staff.js') }}"></script>
        <script src="{{ asset('js/storeadmin/dashboard-controls.js') }}"></script>
    @endsection
@endsection
