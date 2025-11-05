<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    protected $appends = ['fprice', 'product'];

    public function getFpriceAttribute()
    {
        $getPrice = $this->price;
        $fprice = number_format($getPrice, 2, '.', '');

        return $this->attributes['fprice'] = $fprice;

    }

    public function getProductAttribute()
    {
        $productId = $this->product_id;
        $productName = '';
        $findProduct = Product::find($productId);
        if ($findProduct) {
            $productName = $findProduct->name;
            // $productName = $findProduct->name .' ('. $this->size . ')';
        }

      return $this->attributes['product'] = $productName;

    }
}
