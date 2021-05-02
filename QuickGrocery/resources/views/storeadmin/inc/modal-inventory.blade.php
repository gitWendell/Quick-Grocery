{{-- Add Brand --}}
@if((request()->segment(3) == 'brand'))
<div class="inventory-brand-modal modal-brand-hidden">
    <div class="modal-content">
        <div class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>Add Brand</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="registerstore-modal-close"></i>
                </div>
            </div>
        </div>
        <div class="store-modal-body" id="add-brand">
            <form method="POST" id="add-brand-frm" action="{{ action('StoreAdmin\BrandController@create') }}" >
                @csrf
                <label class="form-label" for="name">Brand Name <small><i>(ex. Palmolive, Kopiko etc.)</i></small></label>
                <input class="form-input" type="text" name="name">

                <div class="button-add-brand">
                    <button type="submit" class="addbrandButton">SUBMIT</button>
                </div>
            </form>
        </div>
        <div class="store-modal-footer">

        </div>
    </div>
</div>@endif

@if((request()->segment(3) == 'category'))
{{-- Add Category --}}
<div class="inventory-category-modal modal-category-hidden">
    <div class="modal-content">
        <div class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>Add Category</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="addcategory-modal-close"></i>
                </div>
            </div>
        </div>
        <div class="store-modal-body" id="add-category">
            <form method="POST" id="add-category-frm" action="{{ action('StoreAdmin\CategoryController@create') }}" >
                @csrf
                <label class="form-label" for="name">Category Name <small><i>(ex. Beverages, Personal Care etc.)</i></small></label>
                <input class="form-input" type="text" name="name">

                <div class="button-add-brand">
                    <button type="submit" class="addbrandButton">SUBMIT</button>
                </div>
            </form>
        </div>
        <div class="store-modal-footer">

        </div>
    </div>
</div>

{{-- Add Sub Category --}}
<div class="inventory-subcategory-modal modal-subcategory-hidden">
    <div class="modal-content">
        <div class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>Add Sub Category Value</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="addsubcategory-modal-close"></i>
                </div>
            </div>
        </div>
        <div class="store-modal-body">
            <form method="POST" id="subcategory-frm" action="/" >
                @csrf
                <input type="text" id="id-subcategory" name="id" style="display: none">

                <label class="form-label" for="cat_name">Category Name</label>
                <input class="form-input" type="text" id="category" name="cat_name" disabled>

                <label class="form-label" for="name">Sub Category Name <small><i>(ex. Coffee, Shampoo, Butter etc)</i></small></label>
                <input class="form-input" type="text" name="name">

                <div class="button-add-brand">
                    <button type="submit" class="addbrandButton">SUBMIT</button>
                </div>
            </form>
        </div>
        <div class="store-modal-footer">

        </div>
    </div>
</div>@endif

@if((request()->segment(3) == 'attribute'))
{{-- Add Attribute --}}
<div class="inventory-attribute-modal modal-attribute-hidden">
    <div class="modal-content">
        <div class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>Add Attribute</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="addattribute-modal-close"></i>
                </div>
            </div>
        </div>
        <div class="store-modal-body" id="add-attributes">
            <form method="POST" id="add-attribute" action="{{ action('StoreAdmin\AttributeController@create') }}" >
                @csrf
                <label class="form-label" for="name">Attribute Name <small><i>(ex. Size, Weight, Flavor etc. )</i></small></label>
                <input class="form-input" type="text" name="name">

                <div class="button-add-brand">
                    <button type="submit" class="addbrandButton">SUBMIT</button>
                </div>
            </form>
        </div>
        <div class="store-modal-footer">

        </div>
    </div>
</div>

{{-- Add Attribute Value--}}
<div class="inventory-attributevalue-modal modal-attributevalue-hidden">
    <div class="modal-content">
        <div class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>Add Attribute Value</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="addattributevalue-modal-close"></i>
                </div>
            </div>
        </div>
        <div class="store-modal-body" id="add-subcategory">
            <form method="POST" id="attribute-value" action="/" >
                @csrf
                <input type="text" id="id" name="id" style="display: none;">

                <label class="form-label" for="name">Attribute Name</label>
                <input class="form-input" type="text" id="name" name="name" disabled>

                <label class="form-label" for="name">Attribute Value <small><i>(ex. Large, 1.5LT, 5kg etc.)</i></small></label>
                <input class="form-input" type="text" name="value">

                <div class="button-add-brand">
                    <button type="submit" class="addbrandButton">SUBMIT</button>
                </div>
            </form>
        </div>
        <div class="store-modal-footer">

        </div>
    </div>
</div>@endif


@if((request()->segment(2) == 'inventorymanagement'))
{{-- Update Product --}}
<div class="inventory-updateproduct-modal modal-updateproduct-hidden">
    <div class="modal-content">
        <div class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>Update Product</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="updateproduct-modal-close"></i>
                </div>
            </div>
        </div>
        <div id="update-product-message"></div>
        <div class="store-modal-body">
            <form method="POST" id="updateproduct-frm" action="/" >
                @csrf
                <input type="text" id="id-product" name="id" style="display: none">

                <label class="form-label" for="name">Product Name</label>
                <input class="form-input" type="text" id="product" name="name" required>

                <label class="form-label" for="name">Product Description</label>
                <textarea class="form-textarea" name="product_description" id="product_description" cols="30" rows="10" required></textarea>

                <label class="form-label" for="name">Stock</label>
                <input class="form-input" type="number" name="stock" id="stock" disabled>

                <label class="form-label" for="name">Original Price</label>
                <input class="form-input" type="number" name="original_price" id="origprice">

                <label class="form-label" for="name">Selling Price</label>
                <input class="form-input" type="number" name="selling_price" id="profit">

                <div class="button-add-brand">
                    <button type="submit" class="addbrandButton">SUBMIT</button>
                </div>
            </form>
        </div>
        <div class="store-modal-footer">

        </div>
    </div>
</div>@endif
