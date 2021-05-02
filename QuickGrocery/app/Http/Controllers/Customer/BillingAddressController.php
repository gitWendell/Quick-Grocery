<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\Customer\BillingAddress\BillingAddressCreate;
use App\OrderMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BillingAddress;
use Auth;
class BillingAddressController extends Controller
{

    public function create(BillingAddressCreate $request) {

        $create = $request->validated();
        $create['user_id'] = Auth::id();

        BillingAddress::create($create);
        return redirect('/customer/addresses')->with('success', 'Billing Address Information Added.');
    }

    public function delete($id) {
        $exist = OrderMaster::where('billing', $id)->first();

        if($exist) {
            $data = [
                'error' => 1,
                'message' => 'Cannot delete, this is being used.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        } else {
            BillingAddress::where('id', $id)->delete();
            $data = [
                'error' => 0,
                'message' => 'Delete successfully.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        }
    }
}
