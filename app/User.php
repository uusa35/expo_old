<?php

namespace App;

use App\Models\Category;
use App\Models\UserPermission;


use App\Models\Subscription;
use App\Notifications\MyResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use SoftDeletes, Notifiable;
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'admin_type', 'name', 'email', 'password','image', 'mobile', 'bio','user_type', 'FCM_token', 'api_token', 'device_type','contract_image','admin',
    ];

    /*
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'pivot','admin','balance','facebook','linkedin',
        'twitter','lat','lan','address','bio','contract_image'
    ];
    protected $appends = ['subscription'];
    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPasswordNotification($token));
    }

    public function getImageAttribute($value)
    {
        if($value!=null){
          return url($value);
        }else{
         return "";
        }
      
    }
    public function getUserTypeTextAttribute($value)
    {
       return [1=>'customer', 2=>'expo', 3=>'admin'][$this->user_type];

    }
    public function getSubscriptionAttribute()
    {
//        return @Carbon::now()->diffInDays($this->subscriptions()->orderByDesc('id')->first()->to, false) > 0;
return $this->user_type == 1 ? true : (count($this->subscriptions) ? strtotime($this->subscriptions()->orderByDesc('id')->first()->to) >= strtotime(date('Y-m-d')) : false);
//    return strtotime($this->subscriptions()->orderByDesc('id')->first()->to) > strtotime(date('Y-m-d'));
    }

    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class, 'category_lists');
    // }


    public function permission()
    {
        return $this->hasOne(UserPermission::class,'user_id');
    }
}
