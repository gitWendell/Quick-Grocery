{{-- Register Supplier --}}
@if((request()->segment(2) == 'supplier'))
    <div class="register-supplier-modal register-supplier-hidden">
        <div class="modal-content">
            <div class="store-modal-header">
                <div class="row" style="margin: 0">
                    <div class="modal-header-title">
                        <h3>Add Supplier</h3>
                    </div>
                    <div class="modal-header-close">
                        <i class="fa fa-times" id="registersupplier-modal-close"></i>
                    </div>
                </div>
            </div>
            <div id="supplier-create-message"></div>
            <div class="store-modal-body">
                <form method="POST" id="supplier-create" action="/storeadmin/supplier/create">
                    @csrf
                    <label class="form-label" for="name">Supplier Name</label>
                    <input class="form-input"
                           type="text"
                           data-parsley-minlength="6"
                           data-parsley-maxlength="20"
                           name="name" required>

                    <label for="email">Email</label>
                    <input class="form-input"
                           type="email"
                           name="email" required>

                    <label class="form-label" for="name">Contact number</label>
                    <input class="form-input"
                           type="number"
                           min="0"
                           data-parsley-length="[11, 11]"
                           name="contact" required>

                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
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

    <div class="update-supplier-modal update-supplier-hidden">
        <div class="modal-content">
            <div class="store-modal-header">
                <div class="row" style="margin: 0">
                    <div class="modal-header-title">
                        <h3>Update Supplier</h3>
                    </div>
                    <div class="modal-header-close">
                        <i class="fa fa-times" id="updatesupplier-modal-close"></i>
                    </div>
                </div>
            </div>
            <div id="supplier-update-message"></div>
            <div class="store-modal-body" id="supplier-update-refresh">
                <form method="POST" action="/" id="supplier-update">
                    @csrf
                    <input type="text" name="id" id="id" style="display: none">

                    <label class="form-label" for="name">Supplier Name</label>
                    <input class="form-input"
                           type="text"
                           data-parsley-minlength="6"
                           data-parsley-maxlength="20"
                           name="updateName" id="updateName">

                    <label class="form-label" for="name">Email</label>
                    <input class="form-input"
                           type="email"
                           name="updateEmail" id="updateEmail">

                    <label class="form-label" for="name">Contact</label>
                    <input class="form-input"
                           type="number"
                           min="0"
                           data-parsley-length="[11, 11]"
                           name="updateContact"
                           id="updateContact">

                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="updateStatus" name="status">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
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

@section('scripts')

@endsection
