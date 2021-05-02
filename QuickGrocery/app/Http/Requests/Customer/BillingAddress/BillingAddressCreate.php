<?php

namespace App\Http\Requests\Customer\BillingAddress;

use Illuminate\Foundation\Http\FormRequest;

class BillingAddressCreate extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullname' => ['required', 'string', 'max:255'],
            'mobilenumber' => ['required', 'numeric', 'digits:11'],
            'notes' => ['required', 'string', 'max:255'],
            'completeaddress' => ['required', 'string', 'max:255'],
            'city_id' => ['required'],
            'barangay_id' => ['required']
        ];
    }
}
