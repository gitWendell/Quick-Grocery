<?php

namespace App\Services\StoreAdmin;

use App\Store;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffServices {

    public function createStaffAccount($request) {

        $create = $request->validated();
        $create['password'] = Hash::make($create['password']);
        $create['role'] = 'staff';
        $create['status'] = 'Active';

        $user = User::create($create);

        return $user;
    }

    public function filterPermission($request) {

        $permissions = $request->input('permission');
        $permissionFilter = '';

        foreach ($permissions as $permission) {
            $permissionFilter = $permission . ", " . $permissionFilter;
        }

        return $permissionFilter;
    }

    public function createStaffInformation($request) {

        $store = Store::where('admin_id', Auth::id())->first();

        $create['user_id'] = $this->createStaffAccount($request)->id;
        $create['store_id'] = $store->id;
        $create['permissions'] = $this->filterPermission($request);
        $create['status'] = 'Active';

        return $create;
    }

    public function updateStaffInformation($request) {

        $update['status'] = $request->input('status');
        $update['permissions'] = $this->filterPermission($request);

        return $update;
    }
}
