{{-- Register Supplier --}}
@if((request()->segment(2) == 'supplymanagement'))
    <div class="update-request-stock-modal update-request-stock-hidden">
        <div class="modal-content">
            <div class="store-modal-header">
                <div class="row" style="margin: 0">
                    <div class="modal-header-title">
                        <h3>Add Supplier</h3>
                    </div>
                    <div class="modal-header-close">
                        <i class="fa fa-times" id="updateRequestStock-modal-close"></i>
                    </div>
                </div>
            </div>
            <div class="store-modal-body">
                <form method="POST" action="/" id="update-request-stock-form">
                    @csrf
                    <label class="form-label" for="name">Product Name</label>
                    <input class="form-input" id="name" type="text" name="name">

                    <label class="form-label" for="stock">Stock</label>
                    <input class="form-input" id="stock" type="text" name="stock">

                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="Request">Request</option>
                        <option value="Delivering">Delivering</option>
                        <option value="Delivered">Delivered</option>
                    </select>
                    <div class="button-add-brand">
                        <button type="submit" class="addbrandButton">SUBMIT</button>
                    </div>
                </form>
            </div>
            <div class="store-modal-footer">

            </div>
        </div>
    </div>
@endif
