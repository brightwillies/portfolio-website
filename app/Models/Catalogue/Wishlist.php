<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;


    public function getImageAttribute()
    {
        $product = '';
        $priceId = $this->price_id;
        $image = '';
        $findProductPrice = ProductPrice::find($priceId);
        if ($findProductPrice) {
            $product = Product::find($findProductPrice->product_id);
    
            if($product){
            $image = $product->image;
            }
        }

        return $this->attributes['image'] = $image;
    }

    public function getSlugAttribute()
    {
       
        $priceId = $this->price_id;
        $slug = '';
        $findProductPrice = ProductPrice::find($priceId);
        if ($findProductPrice) {
            $product = Product::find($findProductPrice->product_id);
    
            if($product){
            $slug = $product->slug;
            }
        }

        return $this->attributes['slug'] = $slug;
    }


    public function getSizeAttribute()
    {
        $size = '';
        $priceId = $this->price_id;
        $image = '';
        $findProductPrice = ProductPrice::find($priceId);
        if ($findProductPrice) {
            $size = $findProductPrice->size;
        }

        return $this->attributes['size'] = $size;
    }
    public function getProductAttribute()
    {
        $product = '';
        $priceId = $this->price_id;

        $findProductPrice = ProductPrice::find($priceId);
        if ($findProductPrice) {
            $product = $findProductPrice->product;
        }

        return $this->attributes['product'] = $product;
    }
    public function getPriceAttribute()
    {
        $price = 0;
        $quantity = $this->quantity;
        $priceId = $this->price_id;
        $findProductPrice = ProductPrice::find($priceId);
        if ($findProductPrice) {
            $price = $findProductPrice->price;

            $price = number_format($price, 2, '.', '');

        }

        return $this->attributes['price'] = $price;
    }
}
