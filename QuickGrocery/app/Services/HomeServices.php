<?php

namespace App\Services;

use App\Charts\ExpensesChart;
use App\Charts\ProductTrendChart;
use App\OrderDetails;
use App\OrderMaster;
use App\Staff;
use Carbon\Carbon;

class HomeServices {

    public function monthName() {
        $month_arr = [];

        for ($i = 0; $i < 3; $i++) {
            $now = Carbon::now()->subMonth($i)->monthName;
            array_push($month_arr, $now);
        }

        return $month_arr;
    }

    public function expensesChart(){

        OrderDetails::getOrdersLast3Months();

        $expense_chart = new ExpensesChart;
        $expense_chart->labels($this->monthName());
        $expense_chart->dataset('Order Expenses', 'bar', OrderDetails::getOrdersLast3Months());
        $expense_chart->width(0);
        $expense_chart->height(0);

        return $expense_chart;
    }

    public function productTrend(){
        $pagesServices = new PagesServices();
        $products = [];

        $getOrders = OrderMaster::where('store_id', $pagesServices->storeByRole()->id)->get();

        foreach ($getOrders as $order) {
            foreach ($order->orderdetails as $orderdetail){
                if(array_key_exists($orderdetail->product->name, $products)) {
                    $products[$orderdetail->product->name] = $products[$orderdetail->product->name] + $orderdetail->qty;

                } else {
                    $products[$orderdetail->product->name] = $orderdetail->qty;
                }

            }
        }
        $colors = $this->chartColors(count($products));

        $productTrend = new ProductTrendChart();
        $productTrend->labels(array_keys($products));
        $productTrend->dataset('Product Trends', 'pie', array_values($products))
            ->color($colors[0])
            ->backgroundcolor($colors[1]);
        $productTrend->width(0);
        $productTrend->height(200);

        return $productTrend;
    }

    public function totalOrderToday() {
        $pagesServices = new PagesServices();
        $getOrders = OrderMaster::
                        where('store_id', $pagesServices->storeByRole()->id)
                        ->whereDay('created_at', '=', ''.Carbon::now()->day)
                        ->get();

        return count($getOrders);
    }

    public function totalOrders() {
        $pagesServices = new PagesServices();
        $getOrders = OrderMaster::
                where('store_id', $pagesServices->storeByRole()->id)
                ->get();

        return count($getOrders);
    }

    public function totalStaff() {
        $pagesServices = new PagesServices();
        $staffs = Staff::where('store_id', $pagesServices->storeByRole()->id)->get();

        return count($staffs);
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
}
