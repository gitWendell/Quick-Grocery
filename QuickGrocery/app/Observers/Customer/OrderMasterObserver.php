<?php

namespace App\Observers\Customer;

use App\Cart;
use App\OrderMaster;
use App\OrderDetails;
use App\Product;
use Illuminate\Support\Facades\Auth;

class OrderMasterObserver
{
    public function __construct(){
        $this->userCarts = Cart::getUserCarts(Auth::id())->get();
    }

    /**
     * Handle the order master "created" event.
     *
     * @param  \App\OrderMaster  $order_master
     * @return void
     */
    public function created(OrderMaster $order_master)
    {
        //
        $stores = Cart::getMultiStore();

        foreach($this->userCarts as $userCart){
            if($order_master->store_id == $userCart->product->store_id) {

                $create = [
                    'order_id'      => $order_master->id,
                    'product_id'    => $userCart->product_id,
                    'qty'           => $userCart->qty,
                    'selling_price' => $userCart->product->selling_price
                ];

                OrderDetails::create($create);
            }
        }


    }

    /**
     * Handle the order master "updated" event.
     *
     * @param  \App\OrderMaster  $orderMaster
     * @return void
     */
    public function updated(OrderMaster $orderMaster)
    {
        //
    }

    /**
     * Handle the order master "deleted" event.
     *
     * @param  \App\OrderMaster  $orderMaster
     * @return void
     */
    public function deleted(OrderMaster $orderMaster)
    {
        //
    }

    /**
     * Handle the order master "restored" event.
     *
     * @param  \App\OrderMaster  $orderMaster
     * @return void
     */
    public function restored(OrderMaster $orderMaster)
    {
        //
    }

    /**
     * Handle the order master "force deleted" event.
     *
     * @param  \App\OrderMaster  $orderMaster
     * @return void
     */
    public function forceDeleted(OrderMaster $orderMaster)
    {
        //
    }
}
