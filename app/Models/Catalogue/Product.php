<?php

namespace App\Models\Catalogue;

use App\Models\Catalogue\Category;
use App\Models\Catalogue\ProductCity;
use App\Models\Catalogue\ProductImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['nprices','defaultprice', 'count', 'cities', 'category', 'image', 'images', 'prices', 'status_name', 'featured_name'];

    public function getDefaultpriceAttribute()
    {
        $getID = $this->id;
        $getProducts = ProductPrice::where('product_id', $getID)->first();

        return $this->attributes['defaultprice'] = $getProducts;
    }

    public function getCountAttribute()
    {
        $getID = $this->id;
        $getProducts = Product::where('category_id', $getID)->get()->count();

        return $this->attributes['count'] = $getProducts;
    }

    public function getCitiesAttribute()
    {
        $getName = [];
        $getProductId = $this->id;

        $getItems = @ProductCity::where('product_id', $getProductId)->get();
        if ($getItems->isNotEmpty()) {

            foreach ($getItems as $key => $item) {

                // if ($getName == '') {
                $getName[] = $item->city_id;
                // } else {
                //     $getName  =   $getName . ',' . $item->city_id;
                // }

            }
        }

        return $this->attributes['cities'] = $getName;
    }
    public function getCategoryAttribute()
    {
        $getName = '';
        $id = $this->category_id;

        $find = @Category::find($id);
        if ($find) {
            $getName = $find->name;
        }
        return $this->attributes['category'] = $getName;
    }

    public function getImageAttribute()
    {
        $imageArray = [];
        $getId = $this->id;

        $image = null;
        $getProductId = $this->id;
        $getImage = @ProductImage::where('product_id', $getProductId)->first();
        if ($getImage) {

            $image = $getImage->image;
        }

        return $this->attributes['image'] = $image;
    }

    public function getImagesAttribute()
    {
        $imageArray = [];
        $getId = $this->id;

        $getProductId = $this->id;
        $getImages = @ProductImage::where('product_id', $getProductId)->get();
        if ($getImages->isNotEmpty()) {
            foreach ($getImages as $key => $singImage) {
                $imageArray[] = array('id' => $singImage->id, 'image' => $singImage->image);
            }
            // foreach ($getImages as $key => $singImage) {
            //     $imageArray[] = $singImage->image;
            // }
        }

        return $this->attributes['images'] = $imageArray;
    }

    public function getPricesAttribute()
    {
        $sizesArray = [];

        $getProductId = $this->id;
        $getPrices = @ProductPrice::where('product_id', $getProductId)->get();
        if ($getPrices->isNotEmpty()) {
            foreach ($getPrices as $key => $price) {
                $sizesArray[] = array('size' => $price->size, 'cost' => $price->cost, 'price' => $price->price, 'quantity' => $price->quantity);
            }
        } else {
            $sizesArray[] = array('size' => "", 'cost' => "", 'price' => "", 'quantity' => "");
        }
        return $this->attributes['prices'] = $sizesArray;
    }
    public function getNpricesAttribute()
    {
        $sizesArray = [];

        $getProductId = $this->id;
        $getPrices = @ProductPrice::where('product_id', $getProductId)->get();

        return $this->attributes['Nprices'] = $getPrices;
    }

    public function getStatusNameAttribute()
    {
        $statusName = '';
        $getStatus = $this->status;
        if ($getStatus == 0) {
            $statusName = 'Inactive';
        } elseif ($getStatus == 1) {
            $statusName = 'Active';
        }
        return $this->attributes['status_name'] = $statusName;
    }

    public function getFeaturedNameAttribute()
    {
        $statusName = '';
        $getStatus = $this->featured;
        if ($getStatus == 0) {
            $statusName = 'No';
        } elseif ($getStatus == 1) {
            $statusName = 'Yes';
        }
        return $this->attributes['featured_name'] = $statusName;
    }
}
