<?php

namespace App\Models;

use App\Models\Expo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpoMessage extends Model
{
    use SoftDeletes;
    protected $fillable = ['expo_id', 'status'];
    protected $hidden = ['updated_at', 'deleted_at', 'status'];


    public function message()
    {
        return $this->hasMany('App\Models\Message','msg_id','id');
    }

    public function expo()
    {
        return $this->belongsTo('App\Models\Expo');
    }
}


