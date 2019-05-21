<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryPrice extends Model
{
    use SoftDeletes;
    protected $fillable = ['expo_id','country_id','price'];
    protected $hidden = ['created_at','updated_at', 'deleted_at'];

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

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function expo()
    {
        return $this->belongsTo(Expo::class);
    }
    

    public function getCreatedAtAttribute($value)
    {
     return Carbon::parse($value)->format('d-m-Y');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'category_lists');
    }


 public function product()
    {
          return $this->belongsToMany('App\Models\Product','product_materials');
    }


}


