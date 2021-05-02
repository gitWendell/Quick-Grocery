@extends('systemadmin.inc.layout')

@section('sidebar-content')
<div class="systemadmin-content-header">
    <div class="header-title">
        <h1>Reward Management</h1>
    </div>
</div>
<div id="systemadmin-content-body" class="systemadmin-content-body">
    <div class="row">
        <div class="column-registerstore">
            <button type="button" id="togglemodal-addReward">Add Reward</button>
        </div>
        <div class="column-searchstore">
            <input type="text" id="search_reward" placeholder="Search ...">
            <button type="button">Submit</button>
        </div>
        <div class="column-reports">
            <a href="/system-admin/reward/pdf" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a>
        </div>
    </div>
    @include('inc.messages')
    <table class="storemanagement-table" id="storeDatatable">
        <tr class="tr-header">
            <th>ID</th>
            <th>Code</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        @isset($rewards)
            @foreach($rewards as $reward)
                <tr class="tr-data">
                    <td>{{$reward->id}}</td>
                    <td>{{$reward->code}}</td>
                    <td>{{$reward->startDate}}</td>
                    <td>{{$reward->endDate}}</td>
                    <td>{{$reward->status}}</td>
                    <td style="text-align: center">@if($reward->status == 'Used')
                        @else
                            <a href="/systemadmin/reward/delete/{{$reward->id}}"
                               class="delete-reward danger-btn td-link">
                                Delete
                            </a>
                        @endif</td>
                </tr>
            @endforeach
        @endisset
    </table>
</div>
<div class="systemadmin-content-footer">

</div>
@section('scripts')
    <script src="{{ asset('js/systemadmin/reward-modal.js') }}"></script>
    <script src="{{ asset('js/systemadmin/dashboard-controls.js') }}"></script>
@endsection
@endsection
