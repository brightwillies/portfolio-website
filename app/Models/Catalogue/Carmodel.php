<?php
namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carmodel extends Model
{
    use HasFactory;

    protected $fillable = ['name',  'make_id', 'category_id', 'slug', 'status', 'mask'];

    protected $appends = ['title', 'make'];

    public function getMakeAttribute()
    {

        $name = "";
        $getMakeId = $this->attributes['make_id'];

        if ($getMakeId) {
            $make = Make::find($getMakeId);

            if ($make) {
                $name = $make->name;
            }
        }

        return $this->attributes['make'] = $name;
    }

    public function getTitleAttribute()
    {

        $name = "";

        $getMakeId = $this->attributes['make_id'];

        if ($getMakeId) {
            $make = Make::find($getMakeId);

            if ($make) {
                $name = $make->name . " " . $this->attributes['name'];
            }
        }

        return $this->attributes['title'] = $name;
    }
}
