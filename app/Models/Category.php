<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, Translatable;
    protected $fillable = ['image', 'order_by', 'createdBy'];
    protected $hidden = ['createdBy', 'translations','pivot','order_by', 'created_at', 'updated_at', 'deleted_at', 'status'];
    public $translatedAttributes = ['title', 'details'];

    public function scopePublic($query, $isActive = 'active', $orderBy = 'asc')
    {
        return $query->where(['status' => $isActive])->orderBy('order_by', $orderBy);
    }
    public function getImageAttribute($value)
    {
        return url($value);
    }

    public function getStatusAttribute($value)
    {
        if ($value == 'not_active')
            return "Not Active";
        return "Active";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'createdBy', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

     public function expo()
    {
        return $this->belongsToMany('App\Models\Expo','expo_categories');
    }

     public function product()
    {
        return $this->belongsToMany('App\Models\Product','product_categories');
    }



}


