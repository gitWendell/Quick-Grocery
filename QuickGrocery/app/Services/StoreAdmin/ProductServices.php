<?php

namespace App\Services\StoreAdmin;

use App\Services\PagesServices;

class ProductServices {
    private $pagesServices;

    public function __construct(PagesServices $pagesServices){
        $this->pagesServices = $pagesServices;
    }

    public function create($request) {
        $validated = $request->validated();
        $create = $request->validated();

        $create['name'] = $validated['name'];
        $create['description'] = $validated['description'];
        $create['price'] = $validated['price'];
        $create['selling_price'] = $validated['selling_price'];
        $create['store_id'] = $this->pagesServices->storeByRole()->id;
        $create['brand_id'] = $validated['brand_id'];
        $create['attr_values'] = json_encode($create['attr_values']);
        $create['status'] = 'Active';

        if($request->hasFile('product_image')){
            $filenameWithExt = $request->file('product_image')->getClientOriginalName();
            // Image Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Image Extension
            $extension =$request->file('product_image')->getClientOriginalExtension();

            $create['product_image'] = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('product_image')->storeAs('public/product_images', $create['product_image']);
        } else {
            $create['product_image'] = 'NoImage.jpeg';
        }

        return $create;
    }
}
