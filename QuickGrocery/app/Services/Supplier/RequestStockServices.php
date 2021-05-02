<?php

namespace App\Services\Supplier;

use App\Product;
use App\RequestStock;
use Illuminate\Support\Facades\DB;

class RequestStockServices {

    public function update($request, $id) {

        if ($request['status'] == 'Delivered') {
            $product_id = RequestStock::where('id', $id)->first()->product_id;

            Product::where('id', $product_id)->update(['stock' => DB::raw('stock+' . $request['stock'])]);
        }

        $update['status'] = $request['status'];
        return $update;
    }

}
