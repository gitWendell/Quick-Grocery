<?php

namespace App\Http\Requests\StoreAdmin\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdate extends FormRequest
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
            'updateName' => ['required', 'string', 'max:255'],
            'updateEmail' => ['required', 'string', 'email', 'max:255'],
            'updateContact' => ['required'],
            'status' => ['required']
        ];
    }
}
