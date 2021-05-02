<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SubCategory;

class Category extends Model
{
    //
    protected $fillable = [
        'name',
    ];

    public function subcategory(){
        return $this->hasMany('App\SubCategory', 'category_id', 'id');
    }
}
