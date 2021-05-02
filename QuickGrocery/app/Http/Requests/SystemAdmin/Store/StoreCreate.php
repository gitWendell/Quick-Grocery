<?php

namespace App\Http\Requests\SystemAdmin\Store;

use Illuminate\Foundation\Http\FormRequest;
use Dotenv\Validator;

class StoreCreate extends FormRequest
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
            'store_image' => ['image', 'nullable', 'max:1999'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'store_name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'min:8', 'max:255'],
            'city' => 'required',
            'completeaddress' => 'required',
            'barangay' => 'required'
        ];
    }
}
