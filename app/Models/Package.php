<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Package extends Model
{
    use SoftDeletes ,Translatable;
    protected $fillable = ['duration', 'price', 'order_by', 'createdBy','image'];
    protected $hidden = ['createdBy', 'translations', 'created_at', 'updated_at', 'deleted_at', 'status'];
    public $translatedAttributes = ['title'];

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

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }



}
