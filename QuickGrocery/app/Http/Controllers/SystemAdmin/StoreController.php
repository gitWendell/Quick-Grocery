<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Http\Requests\SystemAdmin\Store\StoreCreate;
use App\Http\Requests\SystemAdmin\Store\StoreUpdate;
use App\Services\SystemAdmin\AccountServices;
use App\Services\SystemAdmin\StoreServices;
use PDF;
use Redirect, Response;
use App\Http\Controllers\Controller;
use App\City;
use App\Store;
use App\User;

class StoreController extends Controller
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
        $users = User::has('store')->paginate(10);

        return view('systemadmin.storemanagement')
                ->with('locations', $this->locations)
                ->with('users', $users);
    }

    public function storeStoreInformation(StoreCreate $request, AccountServices $accountServices, StoreServices $storeServices)
    {
        // Create Store Admin Account
        $user = $accountServices->createStoreAdmin($request);

        // Create Store Information
        Store::create($storeServices->create($request, $user));

        return redirect('/systemadmin/storemanagement')->with('success', 'Store Information Saved.');
    }

    public function updateStoreInformation(StoreUpdate $request, $id) {

        //Update User
        $store_id = Store::where('id', $id)->first();
        User::where('id', $store_id->admin_id)->update(array_filter($request->validated()));

        // Update Store Information
        Store::where('id', $id)->update(array_filter($request->validated()));

        return redirect('/systemadmin/storemanagement')->with('success', 'Store Information Updated.');
    }

    public function generatePDF() {
        $users = User::all();

        // share data to view
        view()->share('users',$users);
        $pdf = PDF::loadView('PDF.systemadmin.StorePDF', $users);

        // download PDF file with download method
        return $pdf->stream('pdf_file.pdf');
    }

}
