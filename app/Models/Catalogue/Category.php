<?php
namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $appends = ['count'];

    protected $fillable = ['name', 'image', 'image_filename', 'slug', 'status', 'mask'];

    // public function getCnameAttribute()
    // {

    //     $name              = $this->name;
    //     $capitalizedString = Str::title($name);
    //     return $this->attributes['cname'];

    // }

    public function getCountAttribute()
    {
        $getID = $this->id;
        // $getProducts = Product::where('category_id', $getID)->get()->count();

        return $this->attributes['count'] = 0;
    }
}
