<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertisementUs extends Model
{
    use SoftDeletes;
    protected $fillable = ['fullname', 'image', 'email', 'mobile', 'comment'];
    protected $table = 'advertisement_us';

    public function getImageAttribute($value)
    {
        return url($value);
    }

}
