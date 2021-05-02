<?php

namespace  App\Services\Customer;

use App\Cart;
use App\ReusableCart;
use App\ReusableCartlist;
use App\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReusableCartServices {

    public function create() {
        $user_carts = Cart::where('user_id', Auth::id())->get();
        if (!$user_carts) { return redirect()->back(); }

        $createList['user_id'] = Auth::id();
        $createList['status'] = 'Active';
        $cart_list = ReusableCartlist::create($createList);

        foreach ($user_carts as $user_cart) {
            $create['cartlist_id'] = $cart_list->id;
            $create['product_id'] = $user_cart['product_id'];
            $create['qty'] = $user_cart['qty'];
            ReusableCart::create($create);
        }
    }

    public function addToCart($id) {

        $reuse_cartlist = ReusableCartlist::where('id', $id)->first();
        $cart_exists = Cart::where('user_id', Auth::id())->get();

        foreach ($reuse_cartlist->reusablecarts as $reusablecart) {
            $updateThisCart = Cart::where('product_id', $reusablecart->product_id)->first();

            if (sizeof($cart_exists) == 0 || $updateThisCart == null) {
                $this->addReusableListToCart($reusablecart);
            } else {
               Cart::where('product_id', $reusablecart->product_id)->update(['qty' => DB::raw('qty+' . $reusablecart->qty)]);
            }


        }
    }

    public function addReusableListToCart($reusablecart) {

        $create['user_id'] = Auth::id();
        $create['product_id'] = $reusablecart['product_id'];
        $create['qty'] = $reusablecart['qty'];

        Cart::create($create);
    }

    public function fetchSelectedReusableCartList($id) {

        $reusableCarts = ReusableCartlist::where('id', $id)->first()->reusablecarts;
        $total = 0;

        $output = '';
        $output .='<td class="cartList_id" data-id="'.$reusableCarts->first()->id.'" data-cartId="'.$reusableCarts->first()->cartlist_id.'">
                        '.$reusableCarts->first()->id.'
                        </td>';
        if ( sizeof($reusableCarts) > 1) {
            $output .='<td>';
            foreach ($reusableCarts as $reusableCart) {
                $output .= ''.$reusableCart->product->name.' x
                        <input id="qty-change-'.$reusableCarts->first()->id.'" class="qty-change"
                        data-id="'.$reusableCart->product->id.'"
                        type="text" value="'.$reusableCart->qty.'">  ';
                $total = $total + ($reusableCart->qty * ($reusableCart->product->origprice + $reusableCart->product->profit));
            }
            $output .= '</td>';
            $output .= '<td>'.$total.'</td>';
        } else {
            $output .= '<td>'.$reusableCarts->first()->product->name.' x
                        <input id="qty-change-'.$reusableCarts->first()->id.'" class="qty-change"
                        data-id="'.$reusableCarts->first()->product->id.'"
                        type="text" value="'.$reusableCarts->first()->qty.'"> </td>';
            $output .= '<td> P '.$reusableCarts->first()->qty * ($reusableCarts->first()->product->origprice + $reusableCarts->first()->product->profit).'</td>';
        }

        return $output;
    }

    public function fetchProductBySelectStore($id) {
        $products = Store::where('id', $id)->first()->products;

        $output = '<div class="row shopping-content" style="margin: 0 !important;">';
        foreach ($products as $product) {
            $output .='
                <div class="location-content-card">
                    <div class="location-content-store">
                        <div class="location-content-store-header">
                            <img src="/storage/product_images/'.$product->product_image.'" width="200px" height="100px">
                        </div>
                        <div class="location-content-store-body">
                            <div class="location-content-card-name">
                                <h5>'.$product->name.'</h5>
                            </div>
                            <div class="location-content-card-description">
                                <p>'.$product->description.'</p>
                            </div>
                            <div class="location-content-card-price">
                                <p>P '.number_format($product->origprice+$product->profit).'</p>
                            </div>
                        </div>
                        <div class="row location-content-store-footer" style="margin:0 auto">
                            <input type="text" id="qty-id-'.$product->id.'" class="shopping-input" name="qty" placeholder="Qty" >
                            <button type="button" class="product-select shopping-button"
                                    data-id="'.$product->id.'">
                                    Add </button>
                        </div>
                    </div>
                </div>
            ';
        }

        $output .= '</div>';

        return $output;
    }

    public function addProductToReusableList($id, $qty, $cartListId) {

        $productExist = ReusableCart::where([
            ['cartlist_id', $cartListId],
            ['product_id', $id],
        ])->get();

        if (sizeof($productExist) > 0) {
            ReusableCart::where([
                ['cartlist_id', $cartListId],
                ['product_id', $id],
            ])->update(['qty' => DB::raw('qty+' . $qty)]);
        } else {
            $create['cartlist_id'] = $cartListId;
            $create['product_id'] = $id;
            $create['qty'] = $qty;

            ReusableCart::create($create);
        }

        $ouput = '
        <div class="message-success">
           Added successfully
         </div>';

        return $ouput;
    }
}
