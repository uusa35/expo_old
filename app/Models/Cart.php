<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['product', 'color', 'material', 'size'];
    protected $appends = ['product_name', 'product_image', 'product_color', 'product_material', 'product_size'];//product_details


    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function getProductDetailsAttribute()
    {
        $p = @$this->product;
        return $p ? $p : "";
    }

    public function getProductNameAttribute()
    {
        $p = @$this->product->title;
        return $p ? $p : "";
    }

    public function getProductImageAttribute()
    {
        $p = @$this->product->cover_image;
        return $p ? $p : "";
    }

    public function getProductColorAttribute()
    {
        $p = @$this->color->name;
        return $p ? $p : "";
    }

    public function getProductMaterialAttribute()
    {
        $p = @$this->material->name;
        return $p ? $p : "";
        // return $this->color_id;
    }

    public function getProductSizeAttribute()
    {
        $p = @$this->size->name;
        return $p ? $p : "";
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

/*    public function user_order()
    {
        return $this->belongsTo(UserOrder::class, 'order_id', 'id');

        // return $this->order_id;
        // return $this->belongsTo('App\Models\UserOrder');
    }*/

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
    
    public function expo()
    {
        return $this->belongsTo('App\Models\Expo');
    }

}


