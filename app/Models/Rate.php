<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = ['user_id', 'product_id','rate','comment'];
    protected $hidden = [ 'updated_at','deleted_at'];
    protected $appends = ['user'];

    public function getUserAttribute()
    {
        return User::query()->where('id',$this->attributes['user_id'])
            ->select('id','name','email','mobile')->first();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

}
