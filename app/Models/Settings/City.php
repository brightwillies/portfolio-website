<?php

namespace App\Models\Settings;

use App\Models\Catalogue\ProductCity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $appends = ['status_name', 'count'];

    public function getCountAttribute()
    {
        $id = $this->id;
        $total = ProductCity::where('city_id', $id)->count();
        return $this->attributes['count'] = $total;

    }
    public function getStatusNameAttribute()
    {
        $statusName = 'Inactive';
        $getStatus = (int) $this->status;

        if ($getStatus == 1) {
            $statusName = 'Active';
        }

        return $this->attributes['status_name'] = $statusName;
    }

}
