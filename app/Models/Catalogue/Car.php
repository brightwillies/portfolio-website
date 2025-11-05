<?php
namespace App\Models\Catalogue;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $appends = ['imagecount', 'days_ago', 'makerslug', 'fprice', 'title', 'images', 'image', 'category', 'status_name'];

    public function getDaysAgoAttribute()
    {
        return $this->attributes['days_ago'] = Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getFpriceAttribute()
    {
        $getPrice = $this->price;
        // $fprice = number_format($getPrice, 2, '.', '');
        $fprice = number_format($getPrice, 2, '.', ',');

        return $this->attributes['fprice'] = $fprice;

    }

    public function getFeaturesAttribute($value): array
    {
        // If the value is empty, return an empty array
        if (empty($value)) {
            return [];
        }

        // Split the comma-separated string and transform into array of objects
        return collect(explode(',', $value))->map(function ($feature) {
            return ['feature' => trim($feature)];
        })->toArray();
    }

    public function getStatusNameAttribute()
    {
        $statusName = '';
        $getStatus  = $this->status;
        if ($getStatus == 0) {
            $statusName = 'Inactive';
        } elseif ($getStatus == 1) {
            $statusName = 'Active';
        }
        return $this->attributes['status_name'] = $statusName;
    }

    public function getMakerslugAttribute()
    {
        $imageArray = [];
        $getId      = $this->id;

        $modelslug    =
        $getProductId = $this->model_id;
        $getModel     = @Carmodel::find($getProductId);
        if ($getModel) {
            $makeId = $getModel->make_id;

            if ($makeId) {
                $findMaker = Make::find($makeId);
                $modelslug = $findMaker->slug;
            }
        }

        return $this->attributes['makerslug'] = $modelslug;
    }
    public function getImagesAttribute()
    {
        $imageArray = [];
        $getId      = $this->id;

        $getProductId = $this->id;
        $getImages    = @CarImage::where('car_id', $getProductId)->get();
        if ($getImages->isNotEmpty()) {
            foreach ($getImages as $key => $singImage) {
                $imageArray[] = ['id' => $singImage->id, 'image' => $singImage->image];
            }
            // foreach ($getImages as $key => $singImage) {
            //     $imageArray[] = $singImage->image;
            // }
        }

        return $this->attributes['images'] = $imageArray;
    }
    public function getImagecountAttribute()
    {

        $getId          = $this->id;
        $getImagesCount = @CarImage::where('car_id', $getId)->count();

        return $this->attributes['imagecount'] = $getImagesCount;
    }

    public function getImageAttribute()
    {

        $getId    = $this->id;
        $image    = null;
        $getImage = @CarImage::where('car_id', $getId)->first();
        if ($getImage) {
            $image = $getImage->image;
        }

        return $this->attributes['image'] = $image;
    }

    public function getTitleAttribute()
    {

        $carTitle   = "";
        $getModelId = $this->attributes['model_id'];

        if ($getModelId) {
            $getModel = Carmodel::find($getModelId);
            $carTitle = $getModel->title;
        }

        return $this->attributes['title'] = $carTitle;
    }

    public function getCategoryAttribute()
    {

        $category   = "";
        $getModelId = $this->attributes['model_id'];

        if ($getModelId) {
            $getModel   = Carmodel::find($getModelId);
            $cattgoryId = $getModel->category_id;

            $findCategory = Category::find($cattgoryId);
            $category     = $findCategory->name;

        }
        return $this->attributes['category'] = $category;
    }
}
