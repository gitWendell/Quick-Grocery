<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ReusableCartlist;

class ReusableCart extends Model
{
    protected $fillable = [
        'cartlist_id', 'product_id', 'qty'
    ];

    public function ReusableCartlist() {
        return $this->belongsTo('App\ReusableCartlist');
    }

    public function Product() {
        return $this->hasOne('App\Product','id', 'product_id');
    }
}
