<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    //
    protected $fillable = [
        'code','status', 'discount', 'startDate', 'endDate',
    ];

    public function getAvailableReward() {
        $ordermaster = new OrderMaster();
        $order_amount = $ordermaster->getTotalOrdersMade();
        $rewards = collect([]);

        if($order_amount >= 1000) {
            $rewards = $this->where('startDate', '>=', Carbon::now()->toDateString())
                        ->where('status', '!=', 'Used')
                        ->get();
        }

        return $rewards;
    }
}
