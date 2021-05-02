@extends('storeadmin.inc.layout')

@section('sidebar-content')
@if (request()->segment(3) == 'addproduct')

    <div class="store-content-header">
        <div class="header-title">
            <h1>Add Product Item</h1>
        </div>
    </div>
    <div class="staff-content-body product-content-body">
        <div id="add-product-message">@include('inc.messages')</div>
        <div class="container">
            <form method="POST" id="add-product-form" action="{{ action('StoreAdmin\ProductController@create') }}" enctype="multipart/form-data">
            @csrf
            <div id="refresh-form">
                <label for="name">Product Image</label>
                <input class="form-input" type="file" name="product_image" required>

                <label for="name">Product Name</label>
                <input class="form-input"
                       type="text"
                       data-parsley-minlength="3"
                       data-parsley-maxlength="100"
                       name="name" required>

                <label for="description">Product Description</label>
                <textarea class="form-textarea"
                          name="description" id="" cols="30" rows="10"
                          data-parsley-minlength="6"
                          data-parsley-maxlength="600"
                          required></textarea>

                <label for="origprice">Original Price</label>
                <input class="form-input" type="number"
                       data-parsley-type="number"
                       data-parsley-min="5"
                       data-parsley-max="2000"
                       data-parsley-trigger="keyup"
                       name="price" required>

                <label for="origprice">Selling Price</label>
                <input class="form-input" type="number"
                       data-parsley-type="number"
                       data-parsley-min="5"
                       data-parsley-max="2000"
                       data-parsley-trigger="keyup"
                       name="selling_price" required>

                <label for="stock">Stock</label>
                <input class="form-input"
                       type="number"
                       data-parsley-min="100"
                       data-parsley-max="1000"
                       name="stock"
                       required>

                <label for="profit">Expiration Date</label>
                <input class="form-input"
                       type="date"
                       name="expiration_date" required>

                <label for="brand">Brand</label>
                <select class="form-select" name="brand_id" id="" required>
                    <option value="">Select</option>
                    @isset($brands)
                        @foreach ($brands as $brand)
                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                        @endforeach
                    @endisset
                </select>

                <label for="category">Category</label>
                <select class="form-select" name="category" id="category" required>
                    <option value="">Select</option>
                    @isset($categories)
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    @endisset
                </select>
                <div id="sub-category">

                </div>

                <label for="attribute">Attribute</label>
                <select class="form-select" name="attribute" id="attribute_id" required>
                    <option value="">Select</option>
                    @isset($attributes)
                        @foreach ($attributes as $attribute)
                            <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                        @endforeach
                    @endisset
                </select>

                <div id="attribute-value">

                </div>

                <div id="attribute-value-selected">

                </div>
            </div>
            <div class="button">
                <button type="submit"> Submit </button>
            </div>
        </form>
        </div>
    </div>
    <div class="store-content-footer">

    </div>
@else

@endif
@endsection
@section('scripts')
    <script src="{{ asset('js/storeadmin/inventory-list-assets/addproduct.js') }}"></script>
    <script src="{{ asset('js/storeadmin/dashboard-controls.js') }}"></script>
    <script>

    </script>
@endsection
