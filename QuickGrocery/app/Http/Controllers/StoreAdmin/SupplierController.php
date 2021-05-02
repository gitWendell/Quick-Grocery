<?php

namespace App\Http\Controllers\StoreAdmin;

use App\BillingAddress;
use App\Http\Requests\StoreAdmin\Supplier\SupplierCreate;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdmin\Supplier\SupplierUpdate;
use App\OrderMaster;
use App\Product;
use App\Services\StoreAdmin\SupplierServices;
use App\Supplier;

class SupplierController extends Controller
{
    //
    public function create(SupplierCreate $request, SupplierServices $supplierServices){

        Supplier::create($supplierServices->create($request));

        return redirect('/storeadmin/supplier')->with('success', 'Supplier Information Added.');
    }

    public function update(SupplierUpdate $request, $id){
        $update['name'] = $request['updateName'];
        $update['email'] = $request['updateEmail'];
        $update['contact'] = $request['updateContact'];
        $update['status'] = $request['status'];

        Supplier::where('id', $id)->update($update);

        return redirect('/storeadmin/supplier')->with('success', 'Supplier Information Updated.');
    }

    public function delete($id) {
        $exist = Product::where('supplier_id', $id)->first();

        if($exist) {
            $data = [
                'error' => 1,
                'message' => 'Cannot delete, this is being used.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        } else {
            Supplier::where('id', $id)->delete();
            $data = [
                'error' => 0,
                'message' => 'Delete successfully.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        }
    }
}
