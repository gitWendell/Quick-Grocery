@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Supplier Management</h1>
        </div>
    </div>
    <div class="store-content-body">
        <div class="row">
            <div class="column-registerproduct">
                <button type="button" id="togglemodal-registersupplier">Add Supplier</button>
            </div>
            <div class="column-searchproduct">
                <input type="text" id="search_supplier" placeholder="Search ...">
                <button type="button">Submit</button>
            </div>
            <div class="column-reports">

            </div>
        </div>
        @include('inc.messages')
        <table class="storemanagement-table staffviews" id="storeDatatable">
            <tr class="tr-header">
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            @isset($suppliers)
                @foreach($suppliers as $supplier)
                    <tr class="tr-data">
                        <td class="tr-data-action">{{$supplier->id}}</td>
                        <td>{{$supplier->name}}</td>
                        <td>{{$supplier->email}}</td>
                        <td>{{$supplier->contact}}</td>
                        <td>{{$supplier->status}}</td>
                        <td class="tr-data-action">
                            <button type="button"
                                    class="toggleModal-updateSupplier primary-btn">
                                Update
                            </button>
                            <a href="/storeadmin/supplier/delete/{{$supplier->id}}"
                                class="td-link danger-btn delete-supplier"> Delete </a>
                        </td>
                    </tr>
                @endforeach
            @endisset

        </table>
    </div>
    <div class="store-content-footer">

    </div>

@endsection
@section('scripts')
    <script src="{{ asset('js/storeadmin/supplier-list-assets/supplier.js') }}"></script>
    <script src="{{ asset('js/storeadmin/dashboard-controls.js') }}"></script>
@endsection
