<?php

namespace App\Http\Controllers\Customer;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\OrderMaster\OrderMasterCreate;
use App\Notification;
use App\OrderMaster;
use App\Product;
use App\ProductBatch;
use App\Services\Customer\OrderMasterServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderMasterController extends Controller
{

    //
    public function create(OrderMasterCreate $request, $id, OrderMasterServices $orderMasterServices) {

        // Get User Carts
        $userCarts = Cart::getUserCarts($id)->get();

        foreach ($userCarts as $userCart) {
            $checkAvailability = Product::getAvailableStock($userCart->product_id);

            if ($checkAvailability < $userCart->qty) {
                $product = Product::where('id', $userCart->product_id)->first();

                return redirect()->back()
                        ->with('error', 'Cannot make order due to lack of stocks :
                        '.$product->name.': '.$checkAvailability.' stocks available');
            }
        }

        $orderMasterServices->create($request, $id);

        $notification = Notification::create([
            'user_id' => $userCarts->first()->product->store_id,
            'madeby_id' => Auth::id(),
            'type'    => 'Order',
            'message' => 'New Order by: '. Auth::user()->name
        ]);

        return redirect('/order/asd')
                        ->with('success', 'Your Order is being process.');
    }

    public function update(Request $request, $id) {

        $request->validate([
            'status' => 'required',
        ]);

        $orderMaster = OrderMaster::where('id', $id)->first();

        OrderMaster::where('id', $id)->update(['status' => $request['status']]);

        if($request['status'] == 'Cancel') {
            foreach ($orderMaster->orderdetails as $orderdetail) {
                $product_batch = ProductBatch::where('product_id', $orderdetail->product_id)->where('status', 'Active')->first();
                ProductBatch::where('id', $product_batch->id)->update(['stocks' => DB::raw('stocks+' . $orderdetail->qty)]);
            }
        }

        $notification = Notification::create([
            'user_id' => $orderMaster->store_id,
            'madeby_id' => Auth::id(),
            'type'    => 'Order',
            'message' => 'The oder #'.$orderMaster->id.' is updated to '.$request['status'].'by: '. Auth::user()->name
        ]);

        return redirect()->back()
                    ->with('success', 'Order Updated.');
    }


}
