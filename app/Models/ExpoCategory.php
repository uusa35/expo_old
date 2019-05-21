<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpoCategory extends Model
{
    use SoftDeletes;
    protected $fillable = ['expo_id','category_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'createdBy', 'id');
    }

      public function expoCat()
    {
        return $this->hasMany('App\Models\Category','id', 'category_id');
    }

}


