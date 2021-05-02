<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Http\Requests\SystemAdmin\Account\AccountUpdate;
use Redirect, Response;
use App\Http\Controllers\Controller;
use App\City;
use App\Store;
use App\User;
use PDF;

class AccountController extends Controller
{
    protected $locations;

    //Global Variables
    public function __construct() {

        $this->locations = City::all();
        $this->users = User::all();
        $this->stores = Store::all();
    }

    // Show available cities and barangays
    public function show() {
        $users = User::paginate(15);

        return view('systemadmin.accountmanagement')
                ->with('locations', $this->locations)
                ->with('users', $users);
    }

    public function update(AccountUpdate $request, $id){
        $owenerOfStore = User::where('id', $id)->first();

        if ($owenerOfStore->store){
            Store::where('admin_id', $id)->update(array_filter($request->validated()));
        }

        User::where('id', $id)->update(array_filter($request->validated()));

        return redirect('/systemadmin/accountmanagement')->with('success', 'Account Information Updated.');
    }

    public function generatePDF() {
        $users = User::all();

        // share data to view
        view()->share('users',$users);
        $pdf = PDF::loadView('PDF.systemadmin.AccountPDF', $users);

        // download PDF file with download method
        return $pdf->stream('pdf_file.pdf');
    }

}
