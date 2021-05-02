<?php

namespace App\Http\Controllers\StoreAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdmin\Brand\BrandCreate;
use App\Product;
use Illuminate\Http\Request;
use App\Brand;

class BrandController extends Controller
{
    //
    public function create(BrandCreate $request) {

        Brand::create($request->validated());

        return redirect('/storeadmin/inventorymanagement/brand')->with('success', 'Brand Information Added.');
    }

    public function delete($id) {
        $isUsed = Product::where('brand_id', $id)->first();

        if ($isUsed) {
            $data = [
                'error' => 1,
                'message' => 'Cannot delete, this is being used.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        } else {
            Brand::where('id', $id)->delete();
            $data = [
                'error' => 0,
                'message' => 'Delete successfully.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        }

    }
}
