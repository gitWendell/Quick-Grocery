<?php

namespace App\Services\Customer;

use App\User;
use Illuminate\Support\Facades\Auth;

class  AccountServices {

    public function isEmailUsedByOther($email) {

        $emailexists = User::getEmailByEmail($email)->first();

        if(!$emailexists || $emailexists->id == Auth::id() ) {
            return false;
        } else {
            return true;
        }


    }
}
