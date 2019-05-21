<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImages extends Model
{
    use SoftDeletes;
    protected $fillable = ['image', 'product_id','type','thumb'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function getImageAttribute($value)
    {
           return url($value);
    }
}

   
