<?php

namespace App\Http\Controllers\StoreAdmin;

use App\Http\Requests\Customer\Account\AccountUpdate;
use App\Services\Customer\AccountServices;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AccountManagement extends Controller
{
    //

    public function update(AccountUpdate $request, $id, AccountServices $accountServices) {
        if($accountServices->isEmailUsedByOther($request->input('email')) == true) {
            return redirect()->back()->with('error', 'The email you are trying to change is in used.');
        }

        $update = $request->validated();
        ($update['password'] != null) ? $update['password'] = Hash::make($request['password']) : '';

        User::where('id', $id)->update(array_filter($update));

        return redirect()->back()->with('success', 'Account Information Updated.');
    }
}
