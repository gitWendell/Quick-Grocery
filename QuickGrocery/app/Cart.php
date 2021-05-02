<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    //

    protected $fillable = [
        'user_id', 'qty', 'product_id',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function product(){
        return $this->hasOne('App\Product', 'id', 'product_id');
    }

//    Scopes
//    Get Carts of user by id
    public  function scopeGetUserCarts($query, $id) {
        return $query->where('user_id', $id);
    }

//    Get Product item in Cart by product_id
    public  function scopeGetProductInCart($query, $id) {
        return $query->where('product_id', $id);
    }

    public function scopeSubtotal($query) {
        $items = $query->where('user_id', Auth::id())->get();
        $count = 0;

        foreach ($items as $item) {
            $count = $count + (($item->product->price) * $item->qty);
        }

        return $count;
    }

    public function scopeGetMultiStore($query) {
        $items = $query->where('user_id', Auth::id())->get();
        $dupe = 0;
        $count = [];

        foreach ($items as $item) {
            if($dupe != $item->product->store_id) {
                $dupe = $item->product->store_id;
                array_push($count, $dupe);
            }
        }

        return $count;
    }

    public function getStoreTotal($cartitems) {
        $total = 0;

        foreach ($cartitems as $cartitem) {
            if($this->product->store->id == $cartitem->product->store->id) {
                $total = $total + ($cartitem->product->getActualPrice() * $cartitem->qty);
            }
        }

        return $total;
    }

    public function scopeGetOrderTotal($query, $store_id) {
        $total = 0;
        $userCarts = Cart::where('user_id', Auth::id())->get();

        foreach ($userCarts as $userCart){
            if ($userCart->product->store->id == $store_id) {
                $total = $total + ($userCart->product->selling_price * $userCart->qty);
            }
        }

        return $total;
    }
}
