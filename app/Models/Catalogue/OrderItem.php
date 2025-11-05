<?php

namespace App\Models\Catalogue;

use App\Models\Catalogue\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    //protected $appends = ['image'];
     protected $appends = ['product', 'image'];

    public function getProductAttribute()
    {
        $sizesArray = [];
        $getProductId = $this->product_id;
        $getProduct = @Product::find($getProductId)->first();
        return $this->attributes['product'] = $getProduct->name;
   
    }
    public function getImageAttribute()
    {
        $sizesArray = [];
        $getProductId = $this->product_id;
        $getProduct = @Product::find($getProductId)->first();
        return $this->attributes['image'] = $getProduct->image;
    }
}
