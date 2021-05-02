<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AttributeValue;

class Attribute extends Model
{
    //
    protected $fillable = [
        'name',
    ];

    public function attributevalues(){

        return $this->hasMany('App\AttributeValue', 'attribute_id', 'id');
    }

}
