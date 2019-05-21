<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CafeProducts extends Model
{
    use SoftDeletes, Translatable;
    protected $fillable = ['cafe_id', 'order_by', 'createdBy','image'];
    protected $hidden = ['createdBy', 'created_at', 'updated_at', 'deleted_at', 'status'];
    public $translatedAttributes = ['title', 'details'];

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
    public function users()
    {
        return $this->belongsToMany(User::class, 'category_lists');
    }


}


