{{-- Add Store --}}
@if(Request::segment(2) == 'storemanagement')
<div class="register-store-modal modal-registerstore-hidden">
    <div class="modal-content">
        <div id="store-modal-header" class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>REGISTER A STORE</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="registerstore-modal-close"></i>
                </div>
            </div>
        </div>
        <div class="store-modal-body" id="register-store">
            <form method="POST" id="createStore" action="{{ action('SystemAdmin\StoreController@storeStoreInformation') }}" enctype="multipart/form-data">
                @csrf
                <div class="row" style="margin: 0;">
                    <div class="storeadmin-information">
                        <h4>Store Admin Information</h4>

                        <label for="email">Name</label>
                        <input type="text" name="name">

                        <label for="email">Email</label>
                        <input type="text" name="email">

                        <label for="password">Password</label>
                        <input type="text" name="password" value="AUTO GENERATED" DISABLED>

                    </div>

                    <div class="store-information">
                        <h4>Store Information</h4>

                        <label for="name">Store Image</label>
                        <input type="file" name="store_image">

                        <label for="name">Store Name</label>
                        <input type="text" name="store_name">

                        <label for="description">Description</label>
                        <textarea name="description" cols="30" rows="5" ></textarea>

                        <label for="storelocationCity">City</label>
                        <select name="city">
                            {!! $currentCity = ""; !!}
                            @isset($locations)
                                @foreach ($locations  as $city)
                                    @if ($city->citymunDesc == $currentCity)
                                    @else
                                        <option value="{{$city->id}}">{{$city->citymunDesc}}</option>
                                    @endif
                                    {!! $currentCity = $city->citymunDesc; !!}
                                @endforeach
                            @endisset
                        </select>
                        <label for="storelocationBarangay">Barangay</label>
                        <select name="barangay">
                            @isset ($locations)
                                @foreach ($locations as $location)
                                    @foreach ($location->barangays as $barangay)
                                        <option value="{{$barangay->id}}">{{$barangay->brgyDesc}}</option>
                                    @endforeach
                                @endforeach
                            @endisset
                        </select>
                        <label for="storelocationBarangay">House/Unit/Flr #, Bldg Name, Blk or Lot #</label>
                        <input type="text" name="completeaddress">
                    </div>
                    <div class="button-register-store">
                    <button type="submit">REGISTER</button></div>
                </div>
            </form>
        </div>
        <div class="store-modal-footer">

        </div>
    </div>
</div>

{{-- Update Store --}}
<div class="update-store-modal modal-updatestore-hidden">
    <div class="modal-content">
        <div id="store-update-header" class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>UPDATE A STORE</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="updatestore-modal-close"></i>
                </div>
            </div>
        </div>
        <div class="store-modal-body" id="update-store">
            <form method="POST" id="update-store-form" action="/" data-id="">
                @csrf
                <div class="row" style="margin: 0;">
                    <div class="storeadmin-information">
                        <h4>Store Admin Information</h4>

                        <input id="modal-update-id" type="text" name="store-Id"  style="display:none;" hidden>

                        <label for="email">Email</label>
                        <input id="modal-update-email" type="text" name="email"  disabled>

                    </div>

                    <div class="store-information">
                        <h4>Store Information</h4>

                        <label for="storename">Store Name</label>
                        <input type="text" name="storename" id="modal-update-name" disabled>

                        <label for="storedescription">Description</label>
                        <textarea name="storedescription" cols="30" rows="5" id="modal-update-description" disabled></textarea>

                        <label for="status">Status</label>
                        <select name="status" id="modal-update-status">
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

