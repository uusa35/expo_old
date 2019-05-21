<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use SoftDeletes;
    protected $table = 'ads';
    protected $guarded = [];
    protected $hidden = ['createdBy', 'created_at', 'updated_at', 'deleted_at', 'status'];

//    public $translatedAttributes = ['details'];

    public function scopePublic($query, $isActive = 'active', $orderBy = 'asc')
    {
        return $query->where(['status' => $isActive])->orderBy('order_by', $orderBy);
    }

    public function getImageAttribute($value)
    {
        if($value!=null){
            return url($value);
        }else{
            return "";
        }

    }


}
