<?php

namespace App\Http\Controllers\StoreAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdmin\AttributeValue\AttributeValueCreate;
use App\Product;
use Illuminate\Http\Request;
use App\AttributeValue;

class AttributeValueController extends Controller
{
    //
    public function create(AttributeValueCreate $request, $id) {
        $create = $request->validated();
        $create['attribute_id'] = $id;
        AttributeValue::create($create);

        return redirect('/storeadmin/inventorymanagement/attribute')->with('success', 'Attribute Value Added.');
    }

    public function delete($id) {
        $string = '"'.$id.'"' ;
        $isUsed= Product::where('attr_values', $string)->first();

        if($isUsed) {
            $data = [
                'error' => 1,
                'message' => 'Cannot delete, this is being used.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        } else {
            AttributeValue::where('id', $id)->delete();
            $data = [
                'error' => 0,
                'message' => 'Delete successfully.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        }
    }
}
