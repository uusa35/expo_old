<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes, Translatable;
    protected $fillable = ['image', 'order_by', 'createdBy'];
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

    public function images()
    {
        return $this->hasMany(CompanyImages::class, 'company_id', 'id');
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

}
