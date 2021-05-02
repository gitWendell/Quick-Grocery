<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\Customer\Account\AccountUpdate;
use App\Services\Customer\AccountServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Redirect, Response;
use App\Http\Controllers\Controller;
use App\City;
use App\Store;
use App\User;

class AccountController extends Controller
{
    protected $locations;

    //Global Variables
    public function __construct() {
        $this->locations = City::all();
        $this->users = User::all();
        $this->stores = Store::all();
    }

    public function verify($id) {
        $date = Carbon::now()->toDateTimeString();

        User::where('id', $id)->update(['email_verified_at' => $date]);

        if(session()->has('code')) {
            return view('pages.verified');
        } else {
            return view('pages.verified');
        }

    }

    public function update(AccountUpdate $request, $id, AccountServices $accountServices){

        if($accountServices->isEmailUsedByOther($request->input('email')) == true) {
            return 'Email is used by other user';
        }

        $update = $request->validated();
        ($update['password'] != null) ? $update['password'] = Hash::make($request['password']) : '';

        User::where('id', $id)->update(array_filter($update));

        return redirect('/customer/accountdetails')->with('success', 'Account Information Updated.');
    }

}
