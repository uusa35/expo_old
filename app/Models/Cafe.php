<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cafe extends Model
{
    use SoftDeletes, Translatable;
    protected $fillable = ['logo', 'order_by','user_id', 'createdBy','category_id','time_from','time_to','menu_images','contract_image','discount_code','latitude','longitude','location','rating_avg','discount_code_qr','discount_code_image','smoking_note'];
    protected $hidden = ['createdBy', 'created_at', 'updated_at', 'deleted_at', 'status'];
    public $translatedAttributes = ['title', 'details'];

    public function scopePublicActive($query, $isActive = 'active')
    {
        return $query->where(['status' => $isActive]);
    }

    public function scopePublic($query, $isActive = 'active', $orderBy = 'desc')
    {
        return $query->where(['status' => $isActive])->orderBy('order_by', $orderBy);
    }

    public function scopePublicOrder($query,$orderBy = 'desc')
    {
        return $query->orderBy('order_by', $orderBy);
    }
    public function getImageAttribute($value)
    {
        return url($value);
    }

    public function getLogoAttribute($value)
    {
        return url($value);
    }

    public function getMenuImagesAttribute($value)
    {
        return url($value);
    }

     public function getDiscountCodeImageAttribute($value)
    {
        if(!empty($value)){
          return url($value);
         }else{
          return null;  
         }
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
    public function users()
    {
        return $this->belongsToMany(User::class, 'category_lists');
    }

}


