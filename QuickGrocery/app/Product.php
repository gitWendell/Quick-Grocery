<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Store;
use App\Cart;

class Product extends Model
{
    //
    protected $fillable = [
        'store_id', 'product_id', 'subcat_id', 'brand_id', 'attr_values',
        'product_image', 'name', 'description', 'price', 'selling_price',
   ];


    public function store() {
        return $this->belongsTo('App\Store');
    }

    public function subcategory(){
        return $this->hasOne('App\SubCategory', 'id', 'subcat_id');
    }

    public function brand(){
        return $this->hasOne('App\Brand', 'id', 'brand_id');
    }

    public function rating(){
        return $this->hasMany('App\ProductRating', 'product_id', 'id');
    }

    public function batches(){
        return $this->hasMany('App\ProductBatch', 'product_id', 'id');
    }

    public function cart(){
        return $this->belongsTo('App\Cart');
    }

    public function supplier(){
        return $this->hasOne('App\Supplier', 'id', 'supplier_id');
    }

    public function scopeGetAttributeNameById($query, $id){
        $attr_id = str_replace("\"","", $query->where('id', $id)->first()->attr_values);
        $attr_values = AttributeValue::where('id', $attr_id)->first()->value;

        return $attr_values;
    }

    public function getAttributeName(){
        $attr_id = str_replace("\"","",$this->attr_values);
        $attr_values = AttributeValue::where('id', $attr_id)->first();

        return $attr_values;
    }

    public function getActualPrice() {
        return $this->price;
    }

    public function scopeGetAvailableStock($query, $id){
        $available = $query->where('id', $id)->first();

        return $this->getStocks($available->id);
    }

    public function getStocks($product_id) {
        $products = ProductBatch::where('product_id', $product_id)->where('status', 'Active')->get();
        $stock = 0;

        foreach ($products as $product) {
            $stock = $stock + $product->stocks;
        }

        return $stock;
    }

    public function scopeGetProductStock($query, $product_id) {
        $products = ProductBatch::where('product_id', $product_id)->where('status', 'Activea')->get();
        $stock = 0;

        foreach ($products as $product) {
            $stock = $stock + $product->stocks;
        }

        return $stock;
    }
    public function scopeGetRelatedProduct($query, $product) {

        $relatedProducts = Product::whereHas('subcategory', function ($query) use($product){
            $query->where('name', $product->subcategory->name);
        })->whereNotIn('store_id', [$product->store_id])->get();

        $returnSameProduct = $relatedProducts->where('brand_id', $product->brand_id);

        return $returnSameProduct;
    }
}
