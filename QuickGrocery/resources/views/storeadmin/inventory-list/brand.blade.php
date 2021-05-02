@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Brand</h1>
        </div>
    </div>
    <div class="store-content-body">
        <div class="row">
            <div class="column-registerproduct">
                <button type="button" id="togglemodal-addbrand">Add Brand</button>
            </div>
            <div class="column-searchproduct">
                <input type="text" placeholder="Search ...">
                <button type="button">Submit</button>
            </div>
            <div class="column-reports">
            </div>
        </div>
        @include('inc.messages')
        <table class="storemanagement-table" id="storeDatatable">
            <tr class="tr-header">
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            <div style="display: none;">{{$count=1}}</div>
            @isset($brands)
                @foreach ($brands as $brand)
                    <tr class="tr-data">
                        <td class="tr-data-id">{{ $brand->id }}</td>
                        <td>{{ $brand->name}}</td>
                        <td class="tr-data-action">
                            <a href="/storeadmin/inventorymanagement/brand/delete/{{$brand->id}}"
                                class="delete-brand primary-btn td-link">
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endisset
        </table>
    </div>
    <div class="store-content-footer">

    </div>

    @section('scripts')
        <script src="{{ asset('js/storeadmin/inventory-list-assets/brand.js') }}"></script>
        <script src="{{ asset('js/storeadmin/dashboard-controls.js') }}"></script>
    @endsection
@endsection
