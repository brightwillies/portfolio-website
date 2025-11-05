<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $appends = ['status_name', 'hasactivecities'];

    public function getHasactivecitiesAttribute()
    {
        $isActive = false;
        $id = $this->id;

        $findCities = City::where('region_id', $id)->get();
        if ($findCities->isNotEmpty()) {
            foreach ($findCities as $key => $value) {
                if ($value->count > 0) {
                    $isActive = true;
                    break;
                }
            }
        }
        return $this->attributes['hasactivecities'] = $isActive;
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

}
