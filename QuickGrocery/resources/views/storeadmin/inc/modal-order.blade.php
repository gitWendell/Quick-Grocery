{{-- Update Order --}}
@if((request()->segment(2) == 'ordermanagement'))
<div class="order-update-modal order-update-hidden">
    <div class="modal-content">
        <div class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>Update Order</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="updateorder-modal-close"></i>
                </div>
            </div>
        </div>
        <div id="update-order-message"></div>
        <div class="store-modal-body" id="update-order-store">
            <form method="POST" action="/" id="updateOrder-frm">
                @csrf

                <label class="form-label" for="id">Order Id</label>
                <input class="form-input" type="text" name="id" id="id" disabled>

                <label class="form-label" for="id">Name</label>
                <input class="form-input" type="text" name="cusName" id="cusName" disabled>

                <label class="form-label" for="itemxqty">Items x Qty</label>
                <textarea class="form-textarea" name="itemxqty" id="itemxqty" cols="30" rows="10" disabled></textarea>

                <label class="form-label" for="total">Total</label>
                <input class="form-input" type="text" name="total" id="total" disabled>

                <label class="form-label" for="method">Method</label>
                <input class="form-input" type="text" name="method" id="method" disabled>

                <label class="form-label" for="billing">Billing Address</label>
                <input class="form-input" type="text" name="billing" id="billing" disabled>

                <label class="form-label" for="status">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Select</option>
                    <option value="Packaging">Packaging</option>
                    <option value="Ready">Ready</option>
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
