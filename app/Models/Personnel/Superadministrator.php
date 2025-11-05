<?php

namespace App\Models\Personnel;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Superadministrator extends Model
{
    use HasFactory;


    protected $appends = ['status_name', 'registered_on'];
    protected $hidden = [
        'password',
    ];

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

    public function getRegisteredOnAttribute()
    {

        $dateName = '';
        $getDate = $this->created_at;

        $dateName = date("d-m-Y", strtotime($getDate));
        return $this->attributes['registered_on'] = $dateName;
    }
}
