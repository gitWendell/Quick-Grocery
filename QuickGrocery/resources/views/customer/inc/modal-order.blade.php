@if( Request::segment(2) == 'order' && Request::segment(1) == 'customer')
<div class="update-orderCust-modal update-orderCust-hidden">
    <div class="modal-content">
        <div class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>Update Order</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="update-orderCust-modal-close"></i>
                </div>
            </div>
        </div>
        <div id="customer-order-message"></div>
        <div class="store-modal-body">
            <form method="POST" action="/" id="update-orderCust-frm">
                @csrf

                <label class="form-label" for="itemxqty">Product x Qty</label>
                <textarea class="form-textarea" name="itemxqty" id="itemxqty" cols="30" rows="10" disabled></textarea>

                <label class="form-label" for="total">Total</label>
                <input class="form-input" type="text" name="total" id="total" disabled>

                <label class="form-label" for="method">Method</label>
                <input class="form-input" type="text" name="method" id="method" disabled>

                <label class="form-label" for="billing">Billing Address</label>
                <input class="form-input" type="text" name="billing" id="billing" disabled>

                <label class="form-label" for="status">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="">Select</option>
                    <option value="Cancel">Cancel</option>
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
