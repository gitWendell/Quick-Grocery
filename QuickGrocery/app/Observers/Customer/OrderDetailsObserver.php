<?php

namespace App\Observers\Customer;

use App\Cart;
use App\Notification;
use App\OrderDetails;
use App\Product;
use App\ProductBatch;
use App\RequestStock;
use App\RequestSupply;
use App\Store;
use App\StoreSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderDetailsObserver
{
    public function __construct(){
        $this->userCarts = Cart::getUserCarts(Auth::id())->get();
    }

    /**
     * Handle the order details "created" event.
     *
     * @param  \App\OrderDetails  $order_details
     * @return void
     */
    public function created(OrderDetails $order_details)
    {
        //
        foreach($this->userCarts as $userCart) {

            if($order_details->OrderMaster->store_id == $userCart->product->store_id) {
                $product_batch = ProductBatch::where('product_id', $userCart->product_id)->where('status', 'Active')->first();
                ProductBatch::where('id', $product_batch->id)->update(['stocks' => DB::raw('stocks-' . $userCart->qty)]);

                $hasSettings = StoreSetting::where('store_id', $userCart->product->store_id)->first();

                if($hasSettings && $hasSettings->auto_supply == 1){

                    $checkExist = RequestStock::where('product_id', $userCart->product_id)->first();

                    if ($checkExist) {

                        RequestSupply::create([
                            'product_id' => $userCart->product_id,
                            'store_id' => $userCart->product->store_id,
                            'qty' => $checkExist->stocks,
                            'status' => 'Active',
                        ]);

                        Notification::create([
                            'user_id' => $userCart->product->store_id,
                            'madeby_id' => Auth::id(),
                            'type'    => 'Order',
                            'message' => 'The product #'.$userCart->product->id.' name "'.$userCart->product->name.'" is in need of stocks ! Please go to Request Supply Tab. '
                        ]);
                    }
                }

                $cart = Cart::find($userCart->id);
                $cart->delete();
            }
        }
    }

    /**
     * Handle the order details "updated" event.
     *
     * @param  \App\OrderDetails  $orderDetails
     * @return void
     */
    public function updated(OrderDetails $orderDetails)
    {
        //
    }

    /**
     * Handle the order details "deleted" event.
     *
     * @param  \App\OrderDetails  $orderDetails
     * @return void
     */
    public function deleted(OrderDetails $orderDetails)
    {
        //
    }

    /**
     * Handle the order details "restored" event.
     *
     * @param  \App\OrderDetails  $orderDetails
     * @return void
     */
    public function restored(OrderDetails $orderDetails)
    {
        //
    }

    /**
     * Handle the order details "force deleted" event.
     *
     * @param  \App\OrderDetails  $orderDetails
     * @return void
     */
    public function forceDeleted(OrderDetails $orderDetails)
    {
        //
    }
}
