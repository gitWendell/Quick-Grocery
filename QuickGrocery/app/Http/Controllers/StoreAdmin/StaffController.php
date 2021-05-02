<?php

namespace App\Http\Controllers\StoreAdmin;

use App\Http\Requests\StoreAdmin\Staff\StaffCreate;
use App\Http\Requests\StoreAdmin\Staff\StaffUpdate;
use App\Services\StoreAdmin\StaffServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Redirect, Response;
use Auth;
use App\User;
use App\Staff;
use App\Store;

class StaffController extends Controller
{
    // Constructor
    public function __construct() {
        $this->user = User::all();
    }

    //Create Staff Information
    public function create(StaffCreate $request, StaffServices $staffServices) {

        Staff::create($staffServices->createStaffInformation($request));

        return redirect('/storeadmin/staffmanagement/addstaff')->with('success', 'Staff Information Saved.');
    }

    public function update(StaffUpdate $request, $id, StaffServices $staffServices) {
        $staff = Staff::where('id', $id)->first();

        User::where('id', $staff->user_id)->update(['status' => $request['status']]);

        Staff::where('id', $id)->update($staffServices->updateStaffInformation($request));

         return redirect('/storeadmin/staffmanagement')->with('success', 'Staff Information Updated.');
    }

    public function delete($id) {
        $staff = Staff::where('id', $id)->first();

        User::where('id', $staff->user_id)->delete();
        Staff::where('id', $id)->delete();
    }
}
