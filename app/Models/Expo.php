<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expo extends Model
{
    use SoftDeletes, Translatable;
   // protected $guarded [];
    protected $fillable = ['type_id', 'order_by', 'createdBy','booth_image','user_id',
    'designer_name','designer_image','details','category_id','civil_id','country_id ','product_no',
    'city_name','address','delivery_country_id','delivery_city_id','latitude','longitude'
    ];
    protected $hidden = ['createdBy', 'translations', 'created_at', 'updated_at', 'deleted_at', 'status'];
    protected $appends = ['has_sale'];
    public $translatedAttributes = ['name'];

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

    public function getBoothImageAttribute($value)
    {
        if(!empty($value)){
          return url($value);
         }else{
          return null;  
         }
    }
     public function getCivilIdAttribute($value)
    {
        if(!empty($value)){
          return url($value);
         }else{
          return null;  
         }
    }

    public function getDesignerImageAttribute($value)
    {
        $image = $this->user->image;
        return $image;

    }
    public function getDesignerNameAttribute($value)
    {
        $name = $this->user->name;
        return $name;

    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'category_lists');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

   public function category()
    {
          return $this->belongsToMany('App\Models\Category','expo_categories');
    }

    public function country()
    {
          return $this->belongsToMany(Country::class,'expo_countries')->withPivot('cities');
    }


    public function hisCountry()
    {
          return $this->hasOne('App\Models\Country','id','country_id');
    }
    
    public function getHasSaleAttribute()
    {
        $cnt =  Product::query()->where('expo_id',$this->id)->where('is_sale',1)->where('status','active')->count();
        
        if($cnt > 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}


