<?php

namespace App\Services\SystemAdmin;

use App\Mail\SendStoreOwnerInformation;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AccountServices {

    public function createStoreAdmin ($request){
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $password = substr(str_shuffle(str_repeat($pool, 5)), 0, 20);

        $create = $request->validated();
        $create['password'] = Hash::make($password);
        $create['role'] = "storeadmin";
        $create['status'] = "Active";

        $user = User::create($create);

        $details['email'] = $user->email;
        $details['password'] = $password;

        Mail::to($user->email)->send(new SendStoreOwnerInformation($details));
        User::where('id', $user->id)->update(['email_verified_at' => Carbon::now()->toDateTimeString()]);

        return $user;
    }

}
