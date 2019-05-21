<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'total'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $appends = ['product_name', 'product_image', 'product_color', 'product_material', 'product_size'];//product_details


    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function getProductDetailsAttribute()
    {
        return Product::where('id', $this->product_id)->get();
    }

    public function getProductNameAttribute()
    {
        $p = @Product::where('id', $this->product_id)->first()->title;
        return $p ? $p : '';
    }

    public function getProductImageAttribute()
    {
        $p = @Product::where('id', $this->product_id)->first()->cover_image;
        return $p ? $p : '';
    }

    public function getProductColorAttribute()
    {
            $p = @Color::where('id', $this->color_id)->first()->name;
            return $p ? $p : '';


    }

    public function getProductMaterialAttribute()
    {
        $p = @Material::where('id', $this->color_id)->first()->name;
        return $p ? $p : '';
        // return $this->color_id;
    }

    public function getProductSizeAttribute()
    {
        $p = @Size::where('id', $this->color_id)->first()->name;
        return $p ? $p : '';
    }


    public function color()
    {
        return $this->belongsTo('App\Models\Color');
    }

    public function size()
    {
        return $this->belongsTo('App\Models\Size');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\Material');
    }

    public function user_order()
    {
        return $this->belongsTo(UserOrder::class, 'order_id', 'id');

        // return $this->order_id;
        // return $this->belongsTo('App\Models\UserOrder');
    }

    public function getPriceAttribute($price)
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
    public function getTotalAttribute($price)
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
    
     public function order_expo()
     {
        return $this->belongsTo(Expo::class, 'expo_id', 'id');
     }
}


