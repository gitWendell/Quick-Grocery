{{-- Update Account --}}
@if ( Request::segment(2) == 'accountmanagement')
<div class="update-account-modal modal-updateaccount-hidden">
    <div class="modal-content">
        <div class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>UPDATE AN ACCOUNT</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="updateaccount-modal-close"></i>
                </div>
            </div>
        </div>
        <div class="store-modal-body">
            <form method="POST" id="update-account-form" action="/">
                @csrf
                <div class="row" style="margin: 0;">
                    <div class="accountmanagement-information">
                        <h4>Account Information</h4>

                        <input id="modal-update-account-id" type="text" name="email"  style="display:none;" hidden>

                        <label for="email">Display Name</label>
                        <input id="modal-update-account-displayname" type="text" name="displayname"  disabled>

                        <label for="email">Email</label>
                        <input id="modal-update-account-email" type="text" name="email"  disabled>

                        <label for="email">Role</label>
                        <input id="modal-update-account-role" type="text" name="role"  disabled>

                        <label for="email">Status</label>
                        <select class="form-select"name="status" id="modal-update-account-status">
                            <option value="Active">Active</option>
                            <option value="Block">Block</option>
                        </select>

                    </div>

                    <div class="button-update-store">
                    <button type="submit">UPDATE</button></div>
                </div>
            </form>
        </div>
        <div class="store-modal-footer">

        </div>
    </div>
</div>@endif
