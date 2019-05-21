<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarEvent extends Model
{
    use SoftDeletes, Translatable;
    protected $fillable = ['title','description','type','start_date','end_date','order_by', 'createdBy','expo_id'];
    protected $hidden = ['expo','createdBy', 'translations', 'created_at', 'updated_at', 'deleted_at', 'status'];
    public $translatedAttributes = ['title','description'];
    protected $appends = ['expo_name'];

    public function scopePublic($query, $isActive = 'active', $orderBy = 'asc')
    {
        return $query->where(['status' => $isActive])->orderBy('order_by', $orderBy);
    }
    public function getImageAttribute($value)
    {
        return url($value);
    }
    public function getExpoIdAttribute($value)
    {
        return (string)$value;
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
    public function expo()
    {
        return $this->belongsTo(Expo::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
    public function getExpoNameAttribute()
    {
        return @$this->expo->name;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'category_lists');
    }


}


