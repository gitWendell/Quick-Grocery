@extends('customer.inc.layout')

@section('user-account-content')
    <div class="user-dashboard-content">
        <div class="user-dashboard-content-title">
            <div> Addresses </div>
        </div>
        <div class="customer-dashboard-body">
            @include('inc.messages')
            <table id="customer-address-id" class="customer-address" >
                <tr class="tr-header">
                    <th>Contact Name</th>
                    <th>Complete Address</th>
                    <th>Postcode</th>
                    <th>Mobile Number</th>
                    <th>Action</th>
                </tr>
                @isset($billingaddresses)
                    @foreach ($billingaddresses as $billingaddress)
                        @if ($billingaddress->user_id == Auth::id())
                            <tr>
                                <td>{{$billingaddress->fullname}} </td>
                                <td>{{$billingaddress->completeaddress}} </td>
                                <td>{{$billingaddress->city->citymunDesc}} - {{$billingaddress->city->barangays()->find($billingaddress->barangay_id)->brgyDesc}} </td>
                                <td>{{$billingaddress->mobilenumber}} </td>
                                <td style="text-align: center">
                                    <a class="td-link danger-btn"
                                       id="cust-billing-delete"
                                       href="/cusotmer/billing/delete/{{$billingaddress->id}}">
                                         Delete
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endisset
            </table>
        </div>
        <div class="customer-dashboard-body-buttons">
            <button id="addbilling-modal">Add Billing</button>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('js/customer/billing.js') }}"></script>
    @endsection
@endsection
