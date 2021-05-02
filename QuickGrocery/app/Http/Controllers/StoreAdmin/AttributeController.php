<?php

namespace App\Http\Controllers\StoreAdmin;

use App\AttributeValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdmin\Attribute\AttributeCreate;
use Illuminate\Http\Request;
use App\Attribute;

class AttributeController extends Controller
{
    //
    public function create(AttributeCreate $request) {

        Attribute::create($request->validated());

        return redirect('/storeadmin/inventorymanagement/attribute')->with('success', 'Attribute Information Added.');
    }

    public function delete($id) {
        $isUsed = AttributeValue::where('attribute_id', $id)->first();

        if($isUsed) {
            $data = [
                'error' => 1,
                'message' => 'Cannot delete, this is being used.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        } else {
            Attribute::where('id', $id)->delete();
            $data = [
                'error' => 0,
                'message' => 'Delete successasdfully.'
            ];

            header("Content-Type: application/json");
            return json_encode($data);
        }
    }
}
