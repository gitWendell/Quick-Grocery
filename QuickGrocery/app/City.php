<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Barangay;

class City extends Model
{
    //
    protected $fillable = [
         'psgcCode', 'citymunDesc', 'regDesc', 'provCode', 'citymunCode'
    ];

    public function barangays(){
        return $this->hasMany('App\Barangay', 'citymunCode', 'citymunCode');
    }
}
