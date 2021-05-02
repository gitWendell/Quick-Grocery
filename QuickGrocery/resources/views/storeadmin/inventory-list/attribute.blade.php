@extends('storeadmin.inc.layout')

@section('sidebar-content')
    <div class="store-content-header">
        <div class="header-title">
            <h1>Attribute</h1>
        </div>
    </div>
    <div class="store-content-body">
        <div class="row">
            <div class="column-registerproduct">
                <button type="button" id="togglemodal-addattribute">Add Attribute</button>
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
                <th>Name</th>
                <th>Action</th>
            </tr>
            @isset($attributes)
                @foreach ($attributes as $attribute)
                    <tr class="tr-data">
                        <td width="10%" class="tr-data-id">{{ $attribute->id }}</td>
                        <td width="60%">{{ $attribute->name}}</td>
                        <td class="tr-data-action" width="30%" >
                            <button id="toggleModal-updateStore"
                                    data-id="{{$attribute->id}}"
                                    class="view-value info-btn">
                                View Value
                            </button>
                            <a href="/storeadmin/inventorymanagement/attribute/delete/{{$attribute->id}}"
                                class="danger-btn td-link delete-attribute">
                                Delete
                            </a>
                            <button type="button" class="togglemodal-addattributevalue primary-btn"
                                data-id="{{$attribute->id}}"
                                data-name="{{$attribute->name}}">
                                Add Value
                            </button>
                        </td>
                    </tr>
                    <tr class="tr-header value-view-{{$attribute->id}}" style="display: none">
                        <th>Id</th>
                        <th>Attribute Values Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach($attribute->attributevalues as $key => $attributevalue)
                            <tr style="display: none"
                                id="subcategory-view"
                                class="tr-data value-view-{{$attribute->id}}"
                                >
                                <td style="background: #dfdfdf"class="tr-data-id">{{ $attributevalue->id }}</td>
                                <td style="background: #dfdfdf">{{ $attributevalue->value}}</td>
                                <td style="background: #dfdfdf" class="tr-data-action">
                                    <a href="/storeadmin/inventorymanagement/subattribute/delete/{{$attributevalue->id}}"
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
    @section('scripts')
        <script src="{{ asset('js/storeadmin/inventory-list-assets/attribute.js') }}"></script>
        <script src="{{ asset('js/storeadmin/dashboard-controls.js') }}"></script>
    @endsection
@endsection
