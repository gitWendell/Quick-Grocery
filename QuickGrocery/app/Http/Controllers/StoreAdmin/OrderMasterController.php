<?php

namespace App\Http\Controllers\StoreAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\OrderMaster\OrderMasterCreate;
use App\Notification;
use App\OrderMaster;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderMasterController extends Controller
{
    public function update(Request $request, $id) {
        $this->validate($request, [
            'status' => ['required'],
        ]);

        $order = OrderMaster::where('id', $id)->first();

        Notification::create([
            'user_id' => $order->user_id,
            'madeby_id' => Auth::id(),
            'type'    => 'Order',
            'message' => 'The order #'.$order->id.' is updated to '.$request->input('status').' by: '. Auth::user()->name
        ]);

        OrderMaster::where('id', $id)->update(['status' => $request->input('status')]);

        if($request['status'] == 'Cancel') {
            foreach ($order->orderdetails as $orderdetail) {
                Product::where('id', $orderdetail->product_id)->update(['stock' => DB::raw('stock+' . $orderdetail->qty)]);
            }
        }

        return redirect('/storeadmin/ordermanagement')->with('success', 'Order Information Updated.');
    }

}
