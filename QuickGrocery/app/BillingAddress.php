<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\City;

class BillingAddress extends Model
{
    //id	user_id	city_id	barangay_id	fullname	mobilenumber	notes	completeaddress	created_at	updated_at
    protected $fillable = [
        'user_id', "city_id", 'barangay_id', 'fullname', 'mobilenumber', 'notes', 'completeaddress',
   ];

    public function city(){
        return $this->hasOne('App\City', 'id', 'city_id');
    }

    public function barangay(){
        return $this->hasOne('App\Barangay', 'id', 'barangay_id');
    }
}
