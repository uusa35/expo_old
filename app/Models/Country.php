<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'flag_icon','currency_id', 'createdBy'];
    protected $hidden = ['currency','createdBy','pivot', 'created_at', 'updated_at', 'deleted_at', 'status'];
    protected $appends = ['currency_iso'];

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

     public function getFlagIconAttribute($value)
    {
        if(!empty($value)){
          return url($value);
         }else{
          return null;  
         }
    }
     public function getCurrencyIsoAttribute()
    {
        return @$this->currency()->first()->shortcut;
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'category_lists');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


    public function expo()
    {
        return $this->belongsToMany('App\Models\Expo','expo_countries');
    }

}


