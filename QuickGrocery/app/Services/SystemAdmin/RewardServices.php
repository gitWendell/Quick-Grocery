<?php

namespace App\Services\SystemAdmin;

use App\Reward;

class RewardServices {

    public function create($request) {

        $create = $request->all();
        $create['status'] = 'Active';
        $create['code']   = $this->checkCode();

        return $create;
    }

    public function checkCode() {
        $generatedCode = $this->generateCode();
        $code = Reward::where('code', $generatedCode)->first();

        if(!$code) {
            return $generatedCode;

        }
        return $this->checkCode();
    }

    public function generateCode() {
        $arr = str_split('ABCDEFGHIJKLMNOP');
        shuffle($arr);
        $arr = array_slice($arr, 0, 3);
        $str = implode('', $arr);
        $str = strtoupper($str);
        $number = rand(100, 999);

        return $code = $str . '' . $number;
    }
}
