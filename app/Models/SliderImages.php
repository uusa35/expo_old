<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderImages extends Model
{
    use SoftDeletes;
    protected $fillable = ['image', 'slider_id'];

    public function getImageAttribute($image)
    {
        return url($image);
    }
}
