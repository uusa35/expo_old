<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class UserOrder extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id','order_id','status','total_cost'];
    protected $hidden = [ 'updated_at', 'deleted_at','owner']; 
//    protected $appends = ['owner'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }  

     public function orders()
    {
        return $this->hasMany(Order::class, 'order_id', 'id');
    }   

/*    public function getOwnerAttribute()
    {
        return User::query()->where('id', $this->attributes['user_id'])
            ->select('id', 'name', 'email', 'mobile','image')->first();
    }*/
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d g:i A');
    }
    public function getTotalCostAttribute($price)
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
    public function getExpoTotalAttribute()
    {
        $item= Expo::query()->where('user_id',Auth::id())->first();
        $orders = Order::where('expo_id',$item->id)->where('order_id',$this->id)->sum('total');


        return $orders;

    }

}


