<?php

namespace App\Services\SystemAdmin;

use App\Mail\SendContactUs;
use App\Mail\SendStoreOwnerInformation;
use Illuminate\Support\Facades\Mail;

class StoreServices {

    public function create($request, $user) {

        $create = $request->validated();
        $create['name'] = $request['store_name'];
        $create['admin_id'] = $user->id;
        $create['status'] = "Active";
        $create['candeliver'] = 0;

        if($request->hasFile('store_image')){
            $filenameWithExt = $request->file('store_image')->getClientOriginalName();
            // Image Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Image Extension
            $extension =$request->file('store_image')->getClientOriginalExtension();

            $create['store_image'] = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('store_image')->storeAs('public/store_images', $create['store_image']);
        } else {
            $create['store_image'] = 'NoImage.jpeg';
        }

        return $create;
    }
}
