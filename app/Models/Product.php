<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use SoftDeletes, Translatable;
    public $translatedAttributes = ['title', 'details'];
    protected $fillable = ['cover_image', 'publish_type_id', 'order_by','size_id','clothing_id','material_id','color','type_id','quantity',
        'current_price','old_price','is_sale','discount_percentage' ,'currency_id', 'createdBy', 'highlight','expo_id'];
    protected $hidden = ['createdBy', 'translations', 'updated_at', 'deleted_at', 'status'];
    protected $appends = ['user','is_fav'];
    protected $casts = ['current_price' => 'string'];

//    protected $appends = ['publish_type_id'];

    public function scopePublic($query, $isActive = 'active', $orderBy = 'asc')
    {
        return $query->where(['status' => $isActive])->orderBy('order_by', $orderBy);
    }

    public function getCoverImageAttribute($value)
    {
     if($value!=null){
      return url($value);
     }else{
        return null;
     }
    }

    // public function category()
    // {
    //     return $this->belongsTo(Category::class, 'category_id', 'id')->withTrashed();
    // }

    public function clothingTypes()
    {
        return $this->belongsToMany(ClothingType::class,'product_clothing_types');
    }
    public function occasions()
    {
        return $this->belongsToMany(Occasion::class,'product_occasions');
    }
    public function images()
    {
        return $this->hasMany('App\Models\ProductImages','product_id','id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function publish()
    {
        return $this->belongsTo(Publish::class, 'publish_type_id', 'id');
    }
    
 





    public function getRateAttribute()
    {
        $rate = Rate::query()->where('product_id', $this->attributes['id'])->avg('rate');
        return round($rate);
    }

    public function getCommentsAttribute()
    {
        $data = Rate::query()->where('product_id', $this->attributes['id'])
            ->where('comment', '!=', null)->get();
        return  $data;
    }
    public function getCountCommentsAttribute()
    {
        $data = Rate::query()->where('product_id', $this->attributes['id'])
            ->where('comment', '!=', null)->count();
        return  $data;
    }

    public function getCountLikeAttribute()
    {
        return $data = Like::query()->where('product_id', $this->attributes['id'])->count();

    }

    public function getUserAttribute()
    {
        return User::query()->where('id', $this->attributes['createdBy'])
            ->select('id', 'name', 'email', 'mobile','image')->first();
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

    //  public function manyCategory()
    // {
    //     return $this->hasMany('App\Models\ProductCategory');
    // }

     public function category()
    {
          return $this->belongsToMany('App\Models\Category','product_categories');
    }


     public function colors()
    {
          return $this->belongsToMany('App\Models\Color','product_colors');
    }

     public function materials()
    {
          return $this->belongsToMany('App\Models\Material','product_materials');
    }


public function sizes()
    {
          return $this->belongsToMany('App\Models\Size','product_sizes');
    }

    public function orders()
    {
          return $this->belongsToMany('App\Models\Order');
    }


    public function getIsFavAttribute()
    {
        $user = auth('api')->user();
        if(!empty($user)){
            $found = WishList::query()->where('user_id', $user->id)->where('product_id',$this->attributes['id'])->first();
            if(!empty($found)){
                return 1;
            }else{
             return 0;
            }
        }else{
           return 0;
        }

    }

    public function getCurrentPriceAttribute($price)
    {
        if ($price == 0) {
            return $price;
        }
        if (!isset($_SERVER['HTTP_CURRENCY'])) {
            return $price;
        } else {
            $ToCurrency = $_SERVER['HTTP_CURRENCY'];
        }

        $amount = currencyConverter('KWD', $ToCurrency, $price);
        return number_format((float)$amount, 2, '.', '');

    }
    public function getOldPriceAttribute($price)
    {
        if ($price == 0) {
            return $price;
        }
        if (!isset($_SERVER['HTTP_CURRENCY'])) {
            return $price;
        } else {
            $ToCurrency = $_SERVER['HTTP_CURRENCY'];
        }

        $amount = currencyConverter('KWD', $ToCurrency, $price);
        return number_format((float)$amount, 2, '.', '');

    }


}
