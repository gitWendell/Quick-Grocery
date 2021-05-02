@if( Request::segment(2) == 'addresses' && Request::segment(1) == 'customer')
<div class="add-billing-modal add-billing-hidden">
    <div class="modal-content">
        <div class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>Add Billing Address</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="addbilling-modal-close"></i>
                </div>
            </div>
        </div>
        <div id="customer-billing-message"></div>
        <div class="store-modal-body" id="store-modal-body">
            <form method="POST" id="customer-billing" action="{{ action('Customer\BillingAddressController@create')}} " >
                @csrf

                <label class="form-label" for="name">Contact Name</label>
                <input class="form-input" type="text" name="fullname">

                <label class="form-label" for="mobile">Mobile Number</label>
                <input class="form-input" type="number" name="mobilenumber">

                <label class="form-label" for="notes">Notes</label>
                <input class="form-input" type="text" name="notes">

                <label class="form-label" for="completeaddress">House/Unit/Flr #, Bldg Name, Blk or Lot #</label>
                <input class="form-input" type="text" name="completeaddress">

                <label class="form-label" for="name">City</label>
                <select name="city_id" id="">
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
                <label class="form-label" for="name">Barangay</label>
                <select name="barangay_id" id="">
                    @isset ($locations)
                        @foreach ($locations as $location)
                            @foreach ($location->barangays as $barangay)
                                <option value="{{$barangay->id}}">{{$barangay->brgyDesc}}</option>
                            @endforeach
                        @endforeach
                    @endisset
                </select>

                <div class="button-add-brand">
                    <button type="submit" class="addbrandButton">SUBMIT</button>
                </div>
            </form>
        </div>
        <div class="store-modal-footer">

        </div>
    </div>
</div>@endif
