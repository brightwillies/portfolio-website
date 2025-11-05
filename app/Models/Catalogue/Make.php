<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    use HasFactory;

        protected $fillable = ['name', 'image', 'image_filename', 'slug', 'status','mask'];
}
