@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Category</h1>
        </div>
    </div>
    <div class="store-content-body">
        <div class="row">
            <div class="column-registerproduct">
                <button type="button" id="togglemodal-addcategory">Add Category</button>
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
        <table class="storemanagement-table" id="storeDatatable">
            <tr class="tr-header">
                <th>ID</th>
                <th>Category Name</th>
                <th>Action</th>
            </tr>
            @isset($categories)
                @foreach ($categories as $category)
                    <tr class="tr-data">
                        <td width="10%" class="tr-data-id">{{ $category->id }}</td>
                        <td width="60%" >{{ $category->name}}</td>
                        <td width="30%" class="tr-data-action">
                            <button class="display-subcat info-btn" data-id="{{$category->id}}">View</button>
                            <a href="/storeadmin/inventorymanagement/category/delete/{{$category->id}}"
                               class="danger-btn td-link delete-category">
                                Delete
                            </a>
                            <button type="button"
                                    class="togglemodal-subcategory primary-btn"
                                    data-id="{{$category->id}}"
                                    data-name="{{$category->name}}">
                                Add Sub Category
                            </button>
                        </td>
                    </tr>
                    <tr class="tr-header subcategory-view-{{$category->id}}" style="display: none">
                        <th>Id</th>
                        <th>Sub Category Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach($category->subcategory as $subcategory)
                        <tr class="tr-data subcategory-view-{{$category->id}}"
                            id="subcategory-view"
                            style="display: none">
                            <td style="background: #dfdfdf"class="tr-data-id">{{ $subcategory->id }}</td>
                            <td style="background: #dfdfdf">{{ $subcategory->name}}</td>
                            <td style="background: #dfdfdf" class="tr-data-action">
                                <a href="/storeadmin/inventorymanagement/subcategory/delete/{{$subcategory->id}}"
                                    class="danger-btn td-link delete-subcategory">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endisset
        </table>
    </div>
    <div class="store-content-footer">

    </div>

@endsection
@section('scripts')
    <script src="{{ asset('js/storeadmin/inventory-list-assets/category.js') }}"></script>
    <script src="{{ asset('js/storeadmin/dashboard-controls.js') }}"></script>
@endsection
