<?php

namespace App\Http\Requests\StoreAdmin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreate extends FormRequest
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
            'product_image' => ['image', 'nullable', 'max:1999'],
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'selling_price' => ['required'],
            'expiration_date' => ['required'],
            'stock' => ['required'],
            'subcat_id' => ['required'],
            'brand_id' => ['required'],
            'attr_values' => ['required']
        ];
    }
}
