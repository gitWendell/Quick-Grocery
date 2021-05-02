<?php

namespace App\Http\Controllers\StoreAdmin;

use App\Http\Controllers\Controller;
use App\Services\StoreAdmin\StoreSettingServices;
use App\Store;
use Illuminate\Http\Request;

class StoreSettingController extends Controller
{
    //
    public function create(Request $request, $id, StoreSettingServices $storeSettingServices) {

        Store::where('id', $id)->update($storeSettingServices->update($request, $id));

        return redirect()->back()
                ->with('success', 'Update Success');
    }
}
