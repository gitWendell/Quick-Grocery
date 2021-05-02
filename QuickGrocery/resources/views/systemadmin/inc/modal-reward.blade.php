{{-- Add Reward --}}
@if(Request::segment(2) == 'reward')
<div class="add-reward-modal add-reward-hidden">
    <div class="modal-content">
        <div id="store-modal-header" class="store-modal-header">
            <div class="row" style="margin: 0">
                <div class="modal-header-title">
                    <h3>ADD REWARD</h3>
                </div>
                <div class="modal-header-close">
                    <i class="fa fa-times" id="add-reward-modal-close"></i>
                </div>
            </div>
        </div>
        <div class="store-modal-body" id="register-reward">
            <form method="POST" id="createReward" action="{{ action('SystemAdmin\RewardController@create') }}" >
                @csrf
                <div class="row" style="padding: 0 15px">
                    <div style="width: 45%; margin-right: 10%">
                        <label for="email">Code</label>
                        <input type="text" name="code" placeholder="AUTO GENERATED" disabled>
                    </div>
                    <div style="width: 45%;">
                        <label for="email">Discount P <small>(Fixed Price)</small></label>
                        <input type="text" name="discount">
                    </div>
                </div>

                <label for="email">Start Date</label>
                <input type="date" name="startDate">

                <label for="password">End Date</label>
                <input type="date" name="endDate">

                <div class="button-register-store" style="margin: 0% !important;">
                <button type="submit">Create</button></div>
            </form>
        </div>
        <div class="store-modal-footer">

        </div>
    </div>
</div>@endif
