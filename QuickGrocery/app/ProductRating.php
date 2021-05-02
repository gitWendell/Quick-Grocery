<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    //
    protected $fillable = [
        'user_id', 'order_id', 'product_id', 'rating', 'comment',
    ];

    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

}
