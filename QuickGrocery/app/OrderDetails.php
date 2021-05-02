<?php

namespace App;

use App\OrderMaster;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Product;
use Illuminate\Support\Facades\Auth;

class OrderDetails extends Model
{
    //order_id	product_id	qty
    protected $fillable = [
        'order_id', 'product_id', 'qty', 'selling_price'
    ];

    public function OrderMaster() {
        return $this->belongsTo('App\OrderMaster', 'order_id', 'id');
    }

    public function Product() {
        return $this->hasOne('App\Product','id', 'product_id');
    }

    public function scopeGetOrdersLast3Months($query){

        $monthExpenses = [];
        $monthExpense = 0;

        for ($i = 0; $i < 3; $i++) {

            $orders = $query
                        ->where('created_at', '<=', Carbon::now()->subMonth($i)->toDateTimeString())
                        ->get();

            if (sizeof($orders) != 0) {
                foreach ($orders as $order) {
                    $master = OrderMaster::where('id', $order->order_id)->first();

                    if($order->OrderMaster->user_id == Auth::id()) {
                        if ($master->status == 'Received' || $master->status == 'Reviewed') {
                            $monthExpense = $monthExpense + ($order->selling_price) * $order->qty;
                        }
                    }
                }
            } else {
                $monthExpense = 0;
            }

            array_push($monthExpenses, $monthExpense);
        }

        return $monthExpenses;
    }

    public function getProfit($id) {
        $order_details = OrderDetails::where('id', $id)->first();

        return $order_details->selling_price - $order_details->product->price;
    }
}
