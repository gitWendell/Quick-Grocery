<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    //
    protected $fillable = [
        'brgyCode', "brgyDesc", 'regCode', 'provCode', 'citymunCode'
   ];

    public function city(){
        return $this->belongsTo('App\City');
    }
}
