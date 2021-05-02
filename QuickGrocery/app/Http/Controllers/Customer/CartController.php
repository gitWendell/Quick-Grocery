<?php

namespace App\Http\Controllers\Customer;

use App\Services\PagesServices;
use Illuminate\Http\Request;
use App\Product;
use App\Http\Controllers\Controller;
use App\Cart;
use DB;
use Auth;

class CartController extends Controller
{
    //

    public function getAddToCart(Request $request, $id) {
        $message = '';
        $failed = 1;

        $request->validate([
            'qty' => 'required|numeric|min:1|not_in:0',
        ]);

        $itemexists = Cart::getProductInCart($id)->first();

        ($request['qty'] == null) ? $qty = 1 : $qty = $request['qty'];

        $checkAvailability = Product::getAvailableStock($id);

        if ($checkAvailability < $request['qty']) {
            $product = Product::where('id', $id)->first();

            $message = 'Product cannot add to cart due to lack of stocks:
                        ' .$product->name.': '.$checkAvailability.' stocks available';

            $data = [
                'message' => $message,
                'failed' => $failed
            ];

        } else {
            $create = [
                'user_id' => Auth::id(),
                'product_id' => $id,
                'qty'   => $qty ];

            if(!$itemexists || $itemexists->user_id != Auth::id()) {
                Cart::create($create);
            } else {
                Cart::where('id', $itemexists->id)->update(['qty' => DB::raw('qty+'.$qty)]);
            }

            $message = 'Product item added to cart.';

            $data = [
                'message' => $message,
                'failed' => 0
            ];
        }

        if(!$request->ajax()){
            return redirect()->back();
        }


        header("Content-Type: application/json");
        return json_encode($data);
    }

    public function reduceCartProductQty($id, PagesServices $pagesServices) {

        Cart::where('id', $id)->update(['qty' => DB::raw('qty-1')]);

        $userCart =  Cart::where('user_id', Auth::id())->get();
        $cart = Cart::where('id', $id)->first();

        if($cart->qty == 0) {
            $data = [
                'remove' => 1,
                'sub_total' => ''. $pagesServices->cartSubtotal(),
                'total_qty' => Auth::user()->cart->sum('qty')
            ];

            Cart::where('id', $id)->delete();
        } else {
            $data = [
                'qty' => Cart::where('id', $id)->first()->qty,
                'sub_total' => ''. $pagesServices->cartSubtotal(),
                'store_total' => ''. $cart->getStoreTotal($userCart),
                'total_qty' => Auth::user()->cart->sum('qty')
            ];
        }



        header("Content-Type: application/json");
        return json_encode($data);
    }

    public function changeCartProductQty(Request $request, $id, PagesServices $pagesServices) {

        if($request['qty'] <= 0) {
            $request['qty'] = 0;
        }

        $userCart =  Cart::where('user_id', Auth::id())->get();
        $cart = Cart::where('id', $id)->first();

        if($cart->product->getStocks($cart->product->id) < $request['qty']) {
            $available = $cart->product->getStocks($cart->product->id);

            $data = [
                'error' => 1,
                'message' => 'Cannot proceed. Available stock:' . $available,
                'sub_total' => ''. $pagesServices->cartSubtotal(),
                'store_total' => ''. $cart->getStoreTotal($userCart),
                'total_qty' => Auth::user()->cart->sum('qty')
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        }

        Cart::where('id', $id)->update(['qty' => $request['qty']]);
        $userCartUpdate =  Cart::where('user_id', Auth::id())->get();
        $cartUpdate = Cart::where('id', $id)->first();

        if($cartUpdate->qty == 0) {
            $data = [
                'remove' => 1,
                'sub_total' => ''. $pagesServices->cartSubtotal(),
                'store_total' => ''. $cartUpdate->getStoreTotal($userCartUpdate),
                'total_qty' => Auth::user()->cart->sum('qty')
            ];

            Cart::where('id', $id)->delete();
        } else {
            $data = [
                'qty' => Cart::where('id', $id)->first()->qty,
                'sub_total' => ''. $pagesServices->cartSubtotal(),
                'store_total' => ''. $cartUpdate->getStoreTotal($userCartUpdate),
                'total_qty' => Auth::user()->cart->sum('qty')
            ];
        }



        header("Content-Type: application/json");
        return json_encode($data);
    }

    public function increaseCartProductQty(Request $request, $id, PagesServices $pagesServices) {

        $cart = Cart::where('id', $id)->first();
        $userCart =  Cart::where('user_id', Auth::id())->get();

        if($cart->product->getStocks($cart->product->id) < $cart->qty+1) {
            $available = $cart->product->getStocks($cart->product->id);

            $data = [
                'error' => 1,
                'message' => 'Cannot proceed. Available stock:' . $available,
                'qty' => Cart::where('id', $id)->first()->qty,
                'sub_total' => ''. $pagesServices->cartSubtotal(),
                'store_total' => ''. $cart->getStoreTotal($userCart),
                'total_qty' => Auth::user()->cart->sum('qty')
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        }

        Cart::where('id', $id)->update(['qty' => DB::raw('qty+1')]);
        $userCartUpdate =  Cart::where('user_id', Auth::id())->get();

        $data = [
            'qty' => Cart::where('id', $id)->first()->qty,
            'sub_total' => ''. $pagesServices->cartSubtotal(),
            'store_total' => ''. $cart->getStoreTotal($userCartUpdate),
            'total_qty' => Auth::user()->cart->sum('qty')
        ];

        header("Content-Type: application/json");
        return json_encode($data);
    }
}
