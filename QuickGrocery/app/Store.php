<?php

namespace App;

use App\Services\PagesServices;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Staff;
use App\Product;
use Illuminate\Support\Facades\DB;

class Store extends Model
{
    //
    protected $fillable = [
        'admin_id', 'store_image', 'name', 'candeliver', 'description', 'status', 'city', 'completeaddress', 'barangay',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function cityF(){
        return $this->hasOne('App\City', 'id', 'city');
    }

    public function barangays(){
        return $this->hasOne('App\Barangay', 'id', 'barangay');
    }

    public function storeSettings(){
        return $this->hasOne('App\StoreSetting', 'store_id', 'id');
    }

    public function staffs(){
        return $this->hasMany('App\Staff', 'store_id', 'id');
    }

    public function products(){
        return $this->hasMany('App\Product', 'store_id', 'id');
    }

    public function scopeGetStoreName($query, $id) {
        return $this->where('id', $id)->first()->name;
    }

    public function scopeGetStoreRegistered($query) {
        $stores = Store::whereMonth('created_at', '=', ''.Carbon::now()->month)->get();

        return count($stores);
    }

    public function scopeGetStoreOrderNumber($query) {
        $stores = Store::all();

        $storeCount = 0;
        $getStores = [];

        foreach ($stores as $store) {
            $count_orders = OrderMaster::where('store_id', $store->id)->get();

            $getStores[$store->name] = count($count_orders);
        }

        return $getStores;
    }

    public function scopeGetTotalOrder($query) {
        $pagesServices = new PagesServices();
        $total = 0;
        $getOrders = OrderMaster::where('store_id', $pagesServices->storeByRole()->id)->get();

        foreach ($getOrders as $order) {
            foreach ($order->orderdetails as $orderdetail) {
                $total = $total + ($orderdetail->selling_price * $orderdetail->qty);
            }
        }

        return $total;
    }

    public function scopeGetTotalProfit($query) {
        $pagesServices = new PagesServices();
        $total = 0;

        $getOrders = OrderMaster::where('store_id', $pagesServices->storeByRole()->id, function ($e) {
            $e->where('status', 'Confirm')->orWhere('status', 'Reviewed');
        })->get();

        foreach ($getOrders as $order) {
            foreach ($order->orderdetails as $orderdetail) {
                $total = $total + ($orderdetail->getProfit($orderdetail->id) * $orderdetail->qty);
            }
        }

        return $total;
    }

    public function scopeGetActiveRequestSupply($query) {
        $pagesServices = new PagesServices();
        $total = 0;

        $getOrders = RequestSupply::where('store_id', $pagesServices->storeByRole()->id)->where('status', 'Active')->get();

        return count($getOrders);
    }
}
