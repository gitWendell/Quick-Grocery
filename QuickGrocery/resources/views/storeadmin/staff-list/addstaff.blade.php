@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Add Staff</h1>
        </div>
    </div>
    <div class="staff-content-body">
        <div id="add-staff-message">@include('inc.messages')</div>
        <div class="container">
            <form action="{{ action('StoreAdmin\StaffController@create') }}" id="add-staff-form" method="POST">
            @csrf
            <div id="refresh-form">
                <label for="name">Display Name</label>
                <input type="text" name="name">

                <label for="email">Email</label>
                <input type="text" name="email">

                <label for="password">Password</label>
                <input type="password" name="password">

                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation">

                <label></label>
                <label for="permission">Permision</label>
                <table>
                    <tr>
                        <th width="30%"></th>
                        <th width="20%">Create</th>
                        <th width="20%">Read</th>
                        <th width="20%">Update</th>
                        <th width="20%">Delete</th>
                    </tr>
                    <tr>
                        <td>Inventory Management</td>
                        <td><input type="checkbox" name="permission[]" value="1-CREATE"></td>
                        <td><input type="checkbox" name="permission[]" value="1-READ"></td>
                        <td><input type="checkbox" name="permission[]" value="1-UPDATE"></td>
                        <td><input type="checkbox" name="permission[]" value="1-DELETE"></td>
                    </tr>
                    <tr>
                        <td>Order Management</td>
                        <td><input type="checkbox" name="permission[]" value="2-CREATE"></td>
                        <td><input type="checkbox" name="permission[]" value="2-READ"></td>
                        <td><input type="checkbox" name="permission[]" value="2-UPDATE"></td>
                        <td><input type="checkbox" name="permission[]" value="2-DELETE"></td>
                    </tr>
                </table>
            </div>
            <div class="button">
                <button type="submit"> Submit </button>
            </div>
        </form>
        </div>
    </div>
    <div class="store-content-footer">

    </div>
    @section('scripts')
        <script src="{{ asset('js/storeadmin/dashboard-controls.js') }}"></script>
        <script src="{{ asset('js/storeadmin/staff-list-assets/addStaff.js') }}"></script>
    @endsection
@endsection
