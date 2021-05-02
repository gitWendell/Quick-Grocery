<?php

namespace App\Http\Controllers\Supplier;
use App\Http\Controllers\Controller;

use App\Http\Requests\Supplier\RequestStock\RequestStockUpdate;
use App\RequestStock;
use App\Services\Supplier\RequestStockServices;
use Illuminate\Http\Request;

class RequestStockController extends Controller
{
    //
    public function update(RequestStockUpdate $request, $id, RequestStockServices $requestStockServices) {

        RequestStock::where('id', $id)->update($requestStockServices->update($request, $id));

        return redirect()->back()
                ->with('success','Request Stock Updated');
    }
}
