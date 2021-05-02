{{-- Register Supplier --}}
@if((request()->segment(2) == 'supply'))
    <div class="update-requestSupply-modal update-requestSupply-hidden">
        <div class="modal-content">
            <div class="store-modal-header">
                <div class="row" style="margin: 0">
                    <div class="modal-header-title">
                        <h3>Update Supplier</h3>
                    </div>
                    <div class="modal-header-close">
                        <i class="fa fa-times" id="requestSupply-modal-close"></i>
                    </div>
                </div>
            </div>
            <div id="requestSupply-update-message"></div>
            <div class="store-modal-body" id="request-supply-update">
                <form method="POST" action="/" id="requestSupply-update">
                    @csrf

                    <label class="form-label" for="name">Product Name</label>
                    <input class="form-input" type="text" name="product_name" id="product_name" disabled>

                    <label class="form-label" for="name">Request Qty</label>
                    <input class="form-input" type="text" name="request_qty" id="request_qty" required>

                    <label class="form-label" for="name">Expiration Date</label>
                    <input class="form-input" type="date" name="expiration_date" required>

                    <label class="form-label" for="status">
                        Status
                    </label>

                    <select class="form-select" id="updateStatus" name="status">
                        <option value="Active">Active</option>
                        <option value="Confirm">Confirm</option>
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
