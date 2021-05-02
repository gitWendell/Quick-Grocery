<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Store;

class Staff extends Model
{
    //
    protected $fillable = [
        'permissions', 'status', 'user_id', 'store_id',
    ];

    public function store(){
        return $this->belongsTo('App\Store');
    }
}
