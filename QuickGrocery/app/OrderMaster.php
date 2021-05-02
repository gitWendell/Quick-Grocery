<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OrderDetails;
use Illuminate\Support\Facades\Auth;

class OrderMaster extends Model
{
    protected $fillable = [
        'user_id', 'store_id', 'discount', 'date', 'billing', 'method', 'status', 'total'
    ];

    public function OrderDetails(){
        return $this->hasMany('App\OrderDetails', 'order_id', 'id');
    }

    public function billing_address(){
        return $this->hasOne('App\BillingAddress', 'id', 'billing');
    }

    public function store(){
        return $this->hasOne('App\Store', 'id', 'store_id');
    }

    public function users() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function billing($id) {
        $ordermaster = $this->where('id', $id)->first();

        return ($ordermaster->billing == '') ? 'No Billing Address'
                : $ordermaster->billing_address->city->citymunDesc. ', '.  $ordermaster->billing_address->barangay->brgyDesc;
    }

    public function total($id) {

        $orderMaster = $this->where('id', $id)->first();
        $count = $orderMaster->total;

        if ($orderMaster->discount > 0){
            $reward = Reward::where('id', $orderMaster->discount)->first();
            $count = $count - $reward->discount;
        }

        return $count;
    }

    public function items($id) {
        $orderMaster = $this->where('id', $id)->first();
        $items = '';

        foreach ($orderMaster->orderdetails as $item) {
            $items .= $item->product->name. ' x ' .$item->qty . ', ';
        }

        if ($orderMaster->discount > 0){
            $reward = Reward::where('id', $orderMaster->discount)->first();
            $items .= '(Discount: P'.$reward->discount.')';

        }

        return $items;
    }

    public function getTotalOrdersMade() {
        $orders = $this->where('user_id', Auth::id())->get();

        $count = 0;

        foreach ($orders as $order) {
            foreach ($order->orderdetails as $orderdetail) {
                $count = $count + ($orderdetail->product->getActualPrice() * $orderdetail->qty);
            }
        }

        return $count;
    }
}
