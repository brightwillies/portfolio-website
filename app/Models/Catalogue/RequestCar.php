<?php
namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCar extends Model
{
    use HasFactory;

    protected $fillable = [
        'make_id',
        'model_id',
        'condition',
        'min_mileage',
        'max_mileage',
        'min_year',
        'max_year',
        'min_price',
        'max_price',
        'drive_type',
        'engine_size',
        'color',
        'sender_name',
        'sender_phone',
        'sender_email',
    ];

    protected $appends = ['make_name', 'model_name'];

    public function getMakeNameAttribute()
    {
        $getMakeId = $this->make_id;
        $makeName  = "";
        if ($getMakeId) {
            $findMake = Make::find($getMakeId);

            if ($findMake) {
                $makeName = $findMake->name;
            }
        }
        return $this->attributes['make_name'] = $makeName;
    }
    public function getModelNameAttribute()
    {
        $getMakeId = $this->model_id;
        $makeName  = "";
        if ($getMakeId) {
            $findMake = Carmodel::find($getMakeId);

            if ($findMake) {
                $makeName = $findMake->name;
            }
        }
        return $this->attributes['model_name'] = $makeName;
    }

}
