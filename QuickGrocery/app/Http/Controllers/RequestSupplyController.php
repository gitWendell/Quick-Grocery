<?php

namespace App\Http\Controllers;

use App\Mail\SendContactUs;
use App\Mail\SendRequestSupply;
use App\Product;
use App\ProductBatch;
use App\RequestSupply;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class   RequestSupplyController extends Controller
{
    //

    public function update(Request $request, $id){
        $suppler = RequestSupply::where('id', $id)->first();

        $store = Store::where('id', $suppler->store_id)->first();

        if($request['status'] == 'Confirm') {
            $get = RequestSupply::where('id', $id)->first();

            $createBatch['stocks'] = $request['request_qty'];
            $createBatch['product_id'] = $get->product_id;
            $createBatch['expiration_date'] = $request['expiration_date'];
            $createBatch['status'] = 'Active';

            ProductBatch::create($createBatch);
        }

        RequestSupply::where('id', $id)->update([
            'status' => $request['status'],
            'qty'    => $request['request_qty']
        ]);



        return redirect()->back()->with('success', 'Request Supply update success');
    }
}
