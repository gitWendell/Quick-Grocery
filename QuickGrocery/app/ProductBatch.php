<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductBatch extends Model
{
    //
    protected $fillable = [
        'stocks', 'expiration_date', 'product_id', 'status',
    ];

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
