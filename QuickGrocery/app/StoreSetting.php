<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    //
    protected $fillable = [
        'store_id', 'auto_supply', 'request_on_stock', 'status',
    ];

    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function request_stock(){
        return $this->hasMany('App\RequestStock', 'setting_id', 'id');
    }

}
