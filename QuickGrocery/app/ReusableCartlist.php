<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ReusableCart;

class ReusableCartlist extends Model
{
    //
    protected $fillable = [
        'user_id','status',
    ];

    public function ReusableCarts(){
        return $this->hasMany('App\ReusableCart', 'cartlist_id', 'id');
    }
}
