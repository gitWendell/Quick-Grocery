<?php

namespace App\Http\Controllers\Customer;

use App\Cart;
use App\Http\Controllers\Controller;
use App\ReusableCart;
use App\ReusableCartlist;
use App\Services\Customer\ReusableCartServices;
use App\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReusableCartController extends Controller
{
    //
    public function create(ReusableCartServices $reusableCartServices) {
        $cartEmpty = Cart::where('user_id', Auth::id())->get();

        if($cartEmpty->count() <= 0) {
            $data = [
              'success' => 0,
              'message' =>  'Cannot make reusable cart with empty cart'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        }

        $data = [
            'success' => 1,
            'message' =>  'Current Cart added to the reusable cart'
        ];
        $reusableCartServices->create();

        header("Content-Type: application/json");
        return json_encode($data);
    }

    public function addToCart($id, ReusableCartServices $reusableCartServices) {

        $reusableCartServices->addToCart($id);

        return redirect()->back()
            ->with('success', 'Reusable list added to cart');
    }

    public function delete($id) {
        ReusableCartlist::where('id', $id)->delete();

        $items = ReusableCart::where('cartlist_id', $id)->get();

        foreach ($items as $item) {
            ReusableCart::where('id', $item->id)->delete();
        }
    }

    public function loadReusableCartList($id, ReusableCartServices $reusableCartServices) {
        echo $reusableCartServices->fetchSelectedReusableCartList($id);
    }

    public function loadProduct($id, ReusableCartServices $reusableCartServices) {
        echo $reusableCartServices->fetchProductBySelectStore($id);
    }

    public function changeProductQty($id) {
        $cartListId = $_GET['cartListId'];
        $qty = $_GET['qty'];

        $ouput = '
        <div class="message-success">
           Update successfully
         </div>';

        if ($qty == 0) {
            ReusableCart::where([
                ['cartlist_id', $cartListId],
                ['product_id', $id],
            ])->delete();

            $allListDelete = ReusableCart::where('cartlist_id', $cartListId)->get();

            if (sizeof($allListDelete) == 0) {
                ReusableCartlist::where('id', $cartListId)->delete();
            }

            return $ouput;
        }

        ReusableCart::where([
            ['cartlist_id', $cartListId],
            ['product_id', $id],
        ])->update(['qty' => $qty]);


        return $ouput;
    }

    public function addProductToReusableList($id, ReusableCartServices $reusableCartServices) {
        $cartListId = $_GET['cartListId'];
        $_GET['qty'] == '' ? $qty = 1 : $qty = $_GET['qty'];

        echo $reusableCartServices->addProductToReusableList($id, $qty, $cartListId);
    }
}
