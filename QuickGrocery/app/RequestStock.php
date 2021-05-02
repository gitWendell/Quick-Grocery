<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestStock extends Model
{
    protected $fillable = [
        'setting_id', 'product_id', 'stocks', 'status',
    ];

    public function store_setting(){
        return $this->belongsTo('App\StoreSetting');
    }

    public function product(){
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
