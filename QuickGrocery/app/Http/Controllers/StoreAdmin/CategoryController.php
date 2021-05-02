<?php

namespace App\Http\Controllers\StoreAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdmin\Category\CategoryCreate;
use App\Product;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    //
    public function create(CategoryCreate $request) {

        Category::create($request->validated());

        return redirect('/storeadmin/inventorymanagement/category')->with('success', 'Category Information Added.');
    }

    public function delete($id) {
        $hasSub = SubCategory::where('category_id', $id)->first();

        if($hasSub) {
            $data = [
                'error' => 1,
                'message' => 'Cannot delete, this is being used.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        } else {
            Category::where('id', $id)->delete();
            $data = [
                'error' => 0,
                'message' => 'Delete successfully.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        }
    }
}
