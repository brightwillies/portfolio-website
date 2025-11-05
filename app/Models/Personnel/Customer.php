<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;


    public function getFullnameAttribute()
    {
        $creator = '';

        $creator = $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];

        return $this->attributes['fullname'] = $creator;
    }
}
