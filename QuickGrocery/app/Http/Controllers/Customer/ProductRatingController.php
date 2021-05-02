<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\OrderMaster;
use App\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductRatingController extends Controller
{
    //
    public function create(Request $request, $id)
    {
        $count = 0;

        foreach ($request['product_id'] as $prod_id) {

            $create['user_id'] = Auth::id();
            $create['order_id'] = $id;
            $create['product_id'] = $request['product_id'][$count];
            $create['rating'] = $request['stars'][$count];
            $create['comment'] = $request['comment'][$count];
            ProductRating::create($create);
            OrderMaster::where('id', $id)->update(['status' => 'Reviewed']);

            $count++;
        }

        return redirect('/customer/order')
                ->with('success', 'Thank you for your review.');
    }
}
