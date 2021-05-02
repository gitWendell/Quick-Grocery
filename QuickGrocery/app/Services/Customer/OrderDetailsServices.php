<?php
namespace App\Services\Customer;

use App\OrderDetails;

class OrderDetailsServices {

    public function getSubtotalOrder($id) {

        $order_details = OrderDetails::where('order_id', $id)->get();
        $sub_total = 0;

        foreach ($order_details as $order_detail) {
            $sub_total = $sub_total + ($order_detail->product->origprice+$order_detail->product->profit) * $order_detail->qty;
        }

        return number_format($sub_total, 2);
    }
}
