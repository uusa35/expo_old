<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpoCountry extends Model
{
    use SoftDeletes;
    protected $fillable = ['expo_id','country_id','cities'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];   

}


