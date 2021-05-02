{{-- Update Staff --}}
<div class="inventory-updatestaff-modal modal-updatestaff-hidden">
    <div class="modal-content">
        <div id="modal-staff-message" class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>Update Staff</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="updatestaff-modal-close"></i>
                </div>
            </div>
        </div>
        <div class="store-modal-body updatestaff-modal-body">
            <form method="POST" id="updatestaff-frm">
                @csrf
                <input type="text" name="id"  style="display: none;">

                <label for="name">Email</label>
                <input type="text" id="email" name="email" disabled>

                <label for="name">Status</label>
                <select name="status" id="status">
                    <option value="Active">Active</option>
                    <option value="Block">Block</option>
                </select>

                <label for="name">Permission</label>
                <table class="updateStaff">
                    <tr>
                        <th width="30%"></th>
                        <th width="20%">Create</th>
                        <th width="20%">Read</th>
                        <th width="20%">Update</th>
                        <th width="20%">Delete</th>
                    </tr>
                    <tr>
                        <td>Inventory Management</td>
                        <td><input type="checkbox" name="permission[]" id="InventoryM-CREATE" value="1-CREATE"></td>
                        <td><input type="checkbox" name="permission[]" id="InventoryM-READ" value="1-READ"></td>
                        <td><input type="checkbox" name="permission[]" id="InventoryM-UPDATE" value="1-UPDATE"></td>
                        <td><input type="checkbox" name="permission[]" id="InventoryM-DELETE" value="1-DELETE"></td>

                    </tr>
                    <tr>
                        <td>Order Management</td>
                        <td><input type="checkbox" name="permission[]" id="OrderM-CREATE" value="2-CREATE"></td>
                        <td><input type="checkbox" name="permission[]" id="OrderM-READ" value="2-READ"></td>
                        <td><input type="checkbox" name="permission[]" id="OrderM-UPDATE" value="2-UPDATE"></td>
                        <td><input type="checkbox" name="permission[]" id="OrderM-DELETE" value="2-DELETE"></td>
                    </tr>
                </table>



                <div class="button-add-brand">
                    <button type="submit" class="addbrandButton">SUBMIT</button>
                </div>
            </form>
        </div>
        <div class="store-modal-footer">

        </div>
    </div>
</div>
