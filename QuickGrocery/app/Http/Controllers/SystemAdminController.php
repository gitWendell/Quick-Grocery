<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Redirect, Response;
use App\City;
use App\Store;
use App\User;

class SystemAdminController extends Controller
{
    protected $locations;

    //Global Variables
    public function __construct() {
        $this->locations = City::all();
        $this->users = User::all();
        $this->stores = Store::all();
    }

    // Show available cities and barangays
    public function showStoreInformation()
    {
        return view('systemadmin.storemanagement')
                ->with('locations', $this->locations)
                ->with('users', $this->users);
    }

    public function storeStoreInformation(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'storename' => ['required', 'string', 'max:50'],
            'storedescription' => ['required', 'string', 'min:8', 'max:255'],
            'storelocationCity' => 'required',
            'storelocationBarangay' => 'required'
        ]);
        
        // Create Store Admin Account
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = "storeadmin";
        $user->save();

        // Create Store Information
        $store = new Store;
        $store->name = $request->input('storename');
        $store->admin_id = $user->id;
        $store->description = $request->input('storedescription');
        $store->city = $request->input('storelocationCity');
        $store->barangay = $request->input('storelocationBarangay');
        $store->status = "Active";
        $store->save();

        return redirect('/systemadmin/storemanagement')->with('success', 'Store Information Saved.');
    }
    
    public function updateStoreInformation(Request $request, $id){
        $this->validate($request, [
            'status' => 'required',
        ]);

        // Update Store Information
        $store = Store::find($id);
        $store->status = $request->input('status');
        $store->save();

        return redirect('/systemadmin/storemanagement')->with('success', 'Store Information Updated.');
    }

}
