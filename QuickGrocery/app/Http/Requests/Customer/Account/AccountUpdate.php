<?php

namespace App\Http\Requests\Customer\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class AccountUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    protected function prepareForValidation()
    {
//        if($this->input('password') != null) {
//            $this->merge(array('password' => Hash::make($this->input('password'))));
//        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['confirmed']
        ];
    }
}
