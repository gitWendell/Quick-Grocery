<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestSupply extends Model
{
    public $fillable = [
        'product_id', 'store_id', 'qty', 'status',
    ];

    public function supplier(){
        return $this->hasOne('App\Supplier', 'id', 'supplier_id');
    }

    public function product(){
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
