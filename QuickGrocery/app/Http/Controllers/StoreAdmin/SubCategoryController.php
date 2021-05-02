<?php

namespace App\Http\Controllers\StoreAdmin;

use App\Http\Requests\StoreAdmin\SubCategory\SubCategoryCreate;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubCategory;

class SubCategoryController extends Controller
{
    //
    public function create(SubCategoryCreate $request, $id) {
        $create = $request->validated();
        $create['category_id'] = $id;
        SubCategory::create($create);

        return redirect('/storeadmin/inventorymanagement/category')->with('success', 'Sub Category Added.');
    }

    public function delete($id) {
        $isUsed = Product::where('subcat_id', $id)->first();

        if($isUsed) {
            $data = [
                'error' => 1,
                'message' => 'Cannot delete, this is being used.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        } else {

            SubCategory::where('id', $id)->delete();
            $data = [
                'error' => 0,
                'message' => 'Delete successfully.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        }
    }
}
