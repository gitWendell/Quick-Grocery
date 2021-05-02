<?php

namespace App\Services\Customer;

use App\Cart;
use App\OrderMaster;
use App\Reward;

class OrderMasterServices {

    public function create($request, $id) {

        $stores = Cart::getMultiStore();

        foreach ($stores as $store) {

            $userCarts = Cart::getUserCarts($id)->get();
            $date = date('Y-m-d H:i:s');

            $create = $request->validated();
            $create['user_id'] = $id;
            $create['store_id'] = $store;
            $create['date'] = $date;
            $create['status'] = 'Pending';
            $create['method'] = $request['method'][$store];

            if (session()->has('shipping')) {
                $create['total'] = Cart::getOrderTotal($store)+session()->get('shipping')['amount'];
            } else {
                $create['total'] = Cart::getOrderTotal($store);
            }

            if (session()->has('coupon')) {
                $create['discount'] = session()->get('coupon')['id'];

                Reward::where('id', session()->get('coupon')['id'])->update(['status' => 'Used']);

            } else {
                $create['coupon'] = null;
            }

            if(!$userCarts) {
                return redirect('/');
            }

            OrderMaster::create($create);
        }

        session()->forget('shipping');
        session()->forget('coupon');

        return '';
    }
}
