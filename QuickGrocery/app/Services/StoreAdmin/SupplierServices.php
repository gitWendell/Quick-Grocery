<?php

namespace App\Services\StoreAdmin;

use App\Services\PagesServices;
use App\Store;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SupplierServices {
    private $store;

    public function __construct(PagesServices $pagesServices) {
        $this->store = $pagesServices->storeByRole();
    }

    public function create($request) {

        $create = $request->validated();
        $create['name'] = $request['name'];
        $create['contact'] = $request['contact'];
        $create['email'] = $request['email'];
        $create['store_id'] = $this->store->id;

        return $create;
    }
}
