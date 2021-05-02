<?php

namespace App\Services;

use App\Cart;
use App\Charts\AccountChart;
use App\Charts\ExpensesChart;
use App\Charts\MostUsedStoreChart;
use App\Charts\StoreChart;
use App\OrderDetails;
use App\RequestStock;
use App\Staff;
use App\Store;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PagesServices {

    public function cartSubtotal() {
        if (!Auth::user()) { return; }

        $subtotal = 0;

        foreach ($this->getCartOfUserInDesc() as $cartitem) {
            $subtotal = $subtotal + ($cartitem->qty * number_format($cartitem->product->price, 2));
        }

        return $subtotal;
    }

    public function  getCartOfUserInDesc(){
        if (!Auth::user()) { return; }

        $cartitems = Cart::getUserCarts(Auth::user()->id)->get()->sortByDesc(function ($cartitems) {
            return $cartitems->product->store_id;
        });
        return $cartitems;
    }

    public function storeByRole() {

        if (!Auth::user()) { return; }
        $user_id = User::find(Auth::user()->id);

        if(Auth::user()->role == 'storeadmin') {
            $store_id = $user_id->store->id;
            return $store = Store::find($store_id);
        } else { // if staff
            $store_id = Staff::where('user_id', Auth::id())->first()->store_id;
            return $store = Store::find($store_id);
        }
    }

    public function getStaffByStoreId() {

        if (auth()->user()->role == 'storeadmin') {
            $store_id = auth()->user()->store->id;
        } else {
            $store_id = Staff::where('user_id', Auth::id())->first()->store_id;
        }

        return $staffs = Staff::where('store_id', $store_id)->get();
    }

    public function getRequestStock() {

        if($this->storeByRole()->storesettings != null) {

            $request_stocks = RequestStock::where('setting_id', $this->storeByRole()->storesettings->id)->get();

        } else {
            $request_stocks = '';
        }

        return $request_stocks;
    }

    public function accountChart () {
        $arr = array_map(function($v){return $v; }, range(1, Carbon::now()->daysInMonth));

        $account_chart = new AccountChart;
        $account_chart->labels([Carbon::now()->monthName]);
        $account_chart->dataset('Number of registered account by '. Carbon::now()->monthName, 'bar', [User::getCountRegistered()] )
                        ->color("rgb(255, 99, 132)")
                        ->backgroundcolor("rgb(255, 99, 132)");
        $account_chart->width(0);
        $account_chart->height(200);

        return $account_chart;
    }

    public function storeChart () {
        $arr = array_map(function($v){return $v; }, range(1, Carbon::now()->daysInMonth));

        $store_chart = new StoreChart();
        $store_chart->labels([Carbon::now()->monthName]);
        $store_chart->dataset('Number of registered store by '. Carbon::now()->monthName, 'bar', [Store::getStoreRegistered()] )
                    ->color("rgb(255, 99, 132)")
                    ->backgroundcolor("rgb(255, 99, 132)");
        $store_chart->width(0);
        $store_chart->height(200);

        return $store_chart;
    }

    public function mostUsedStoreChart () {
        $count = count(Store::getStoreOrderNumber());
        $colors = $this->chartColors($count);

        $mostUsedStore = new MostUsedStoreChart();
        $mostUsedStore->labels(array_keys(Store::getStoreOrderNumber()));
        $mostUsedStore->dataset('Store Orders', 'doughnut', array_values(Store::getStoreOrderNumber()))
                    ->color($colors[0])
                    ->backgroundcolor($colors[1]);
        $mostUsedStore->height(200);

        return $mostUsedStore;
    }

    public function activeAndBlockUser () {
        $activeUser = count(User::where('status', 'Active')->get());
        $blockUser = count(User::where('status', 'Block')->get());

        $mostUsedStore = new MostUsedStoreChart();
        $mostUsedStore->labels(['Active User', 'Blocked User']);
        $mostUsedStore->dataset('Store Orders', 'doughnut', [$activeUser, $blockUser])
            ->color(["rgba(255, 99, 132, 1)", "rgba(22,160,133, 1)"])
            ->backgroundcolor(["rgba(255, 99, 132, 0.2)", "rgba(22,160,133, 0.5)"]);
        $mostUsedStore->height(200);

        return $mostUsedStore;
    }

    public function chartColors($count) {
        $colors = [];
        $BGColor = [];

        for($i=0; $i < $count; $i++){

            $collectedColor = $this->random_color();

            array_push($colors, "rgb(".$collectedColor.")") ;
            array_push($BGColor, "rgba(".$collectedColor.", 0.5)") ;
        }

        return [$colors, $BGColor];
    }

    function random_color_part() {

        return rand(0, 255);;
    }

    function random_color() {
        return $this->random_color_part() .", ". $this->random_color_part() .", ". $this->random_color_part();
    }

    public function calculateDistance($lat1, $long1, $lat2, $long2){

        $theta = $long1 - $long2;
        $miles = (sin(deg2rad($lat1))) * sin(deg2rad($lat2)) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);

        $result['miles'] = $miles * 60 * 1.1515;
        $result['feet'] = $result['miles']*5280;
        $result['yards'] = $result['feet']/3;
        $result['kilometers'] = $result['miles']*1.609344;
        $result['meters'] = $result['kilometers']*1000;

        return $result['kilometers'];

    }

}
