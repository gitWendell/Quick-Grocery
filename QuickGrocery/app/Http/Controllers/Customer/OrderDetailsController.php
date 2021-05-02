<?php

namespace App\Http\Controllers\Customer;

use App\Cart;
use App\OrderDetails;
use App\OrderMaster;
use App\Services\Customer\OrderDetailsServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderDetailsController extends Controller
{
    //
    public function afterCheckout($id, OrderDetailsServices $detailsServices){
        $orders = OrderMaster::where('id', $id)->first();

        return view('customer.orderdetails')
                ->with('success', 'Your Order is being process.');
    }

    public function view($id) {
        $order_master = OrderMaster::where('id', $id)->first();

        return view('customer.view')
                ->with('order_master', $order_master);
    }

}
